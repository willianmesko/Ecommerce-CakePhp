<?php
App::uses('AppController', 'Controller');
/**
 * Compras Controller
 *
 * @property Compra $Compra
 * @property PaginatorComponent $Paginator
 */
class ComprasController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function index()
	{
		$this->Paginator->settings = array(
			'conditions'=>array('Compra.usuario_id'=>$this->Auth->user('id')),
			'contain'=>array('Notificacao'=>array('fields'=>array('Notificacao.status')))
		);
		$this->set('compras', $this->Paginator->paginate());
	}

	public function ver($id = null)
	{
		$compra = $this->Compra->getCompra($id);
		if (!$compra)
			throw new NotFoundException(__('Compra inválida'));
		$this->set(compact('compra'));

	}

	public function finalizar()
	{
		$carrinho = $this->Compra->ComprasProduto->Produto->listaCarrinho($this->Cookie->read('carrinho'));
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Compra']['usuario_id']=$this->Auth->user('id');
			unset($this->request->data['Usuario']);
			$this->request->data['ComprasProduto'] = $this->Compra->relacionaProduto($carrinho['produtos']);
			$this->request->data['Compra']['valor']=$this->Compra->totalCompra($carrinho['produtos']);

			$peso = $this->Compra->ComprasProduto->Produto->peso($carrinho);
			$options = array(
				'cep_destino'=>$compra['Compra']['cep'],
				'servico'=>$compra['Compra']['tipo_entrega'],
				'peso'=>$peso,
			);
			$frete = $this->Compra->ComprasProduto->Produto->correios($options);
			$this->request->data['Compra']['valor_frete']=$frete['Servicos']['cServico']['Valor'];
			if ($this->Compra->saveAll($this->request->data)) {
				//$this->Cookie->delete('carrinho');
				return $this->redirect('/compras/confirmar/'.$this->Compra->getLastInsertId());
			}
		}
		$this->request->data = $this->Compra->formataDados($this->Auth->user('id'));
	}

	public function confirmar($id = null)
	{
		$this->Compra->recursive=2;
		$compra = $this->Compra->find('first', array('conditions'=>array('Compra.id'=>$id)));

		if (empty($compra))
			throw new NotFoundException(__('Compra inválida'));

		if ($compra['Compra']['usuario_id']!=$this->Auth->user('id'))
			throw new NotFoundException(__('Compra inválida'));


		$produtos['produtos'] = $compra['ComprasProduto'];
		$peso = $this->Compra->ComprasProduto->Produto->peso($produtos);

		$options = array(
			'cep_destino'=>$compra['Compra']['cep'],
			'servico'=>$compra['Compra']['tipo_entrega'],
			'peso'=>$peso,
		);

		$frete = $this->Compra->ComprasProduto->Produto->correios($options);
		$pagseguro = $this->Compra->pagseguro($produtos, $compra, $frete);
		if (is_array($pagseguro)) {
			throw new NotFoundException(__($pagseguro['msg']));
		}
		$total['produtos'] = $this->Compra->totalCompra($compra['ComprasProduto']);
		$total['geral'] = $total['produtos']+$frete['Servicos']['cServico']['Valor'];
		$this->set(compact('frete','total','pagseguro'));
	}

/**
 * index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Compra->recursive = 0;
		$this->set('compras', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Compra->exists($id)) {
			throw new NotFoundException(__('Invalid compra'));
		}
		$options = array('conditions' => array('Compra.' . $this->Compra->primaryKey => $id));
		$this->set('compra', $this->Compra->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Compra->create();
			if ($this->Compra->save($this->request->data)) {
				$this->Session->setFlash(__('The compra has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The compra could not be saved. Please, try again.'));
			}
		}
		$usuarios = $this->Compra->Usuario->find('list');
		$produtos = $this->Compra->ComprasProduto->Produto->find('list');
		$this->set(compact('usuarios', 'produtos'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Compra->exists($id)) {
			throw new NotFoundException(__('Invalid compra'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Compra->save($this->request->data)) {
				$this->Session->setFlash(__('The compra has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The compra could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Compra.' . $this->Compra->primaryKey => $id));
			$this->request->data = $this->Compra->find('first', $options);
		}
		$usuarios = $this->Compra->Usuario->find('list');
		$produtos = $this->Compra->ComprasProduto->Produto->find('list');
		$this->set(compact('usuarios', 'produtos'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Compra->id = $id;
		if (!$this->Compra->exists()) {
			throw new NotFoundException(__('Invalid compra'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Compra->delete()) {
			$this->Session->setFlash(__('The compra has been deleted.'));
		} else {
			$this->Session->setFlash(__('The compra could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
