<?php
App::uses('AppController', 'Controller');
/**
 * Produtos Controller
 *
 * @property Produto $Produto
 * @property PaginatorComponent $Paginator
 */
class ProdutosController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * beforeFilter callback
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(array('index', 'destaque', 'maisvendidos', 'novos', 'ver', 'carrinho', 'addcarrinho', 'menoscarrinho', 'removecarrinho', 'frete'));
	}

	public function index() {
		$this->Produto->recursive = 0;
		$this->set('produtos', $this->Paginator->paginate());
	}

	public function destaque($limit = 6) {
		if ($this->request->is('requested')) {
			return $this->Produto->destaque($limit);
		}
	}

	public function maisvendidos($limit = 6) {
		if ($this->request->is('requested')) {
			return $this->Produto->maisvendidos($limit);
		}
	}

	public function novos($limit = 6) {
		if ($this->request->is('requested')) {
			return $this->Produto->novos($limit);
		}
	}

	public function ver($slug = null) {
		$conditions = array('Produto.slug'=>$slug);
		$produto = $this->Produto->find('first', compact('conditions'));

		if (empty($produto)) {
			throw new NotFoundException('Produto não encontrado');
		}

		$this->set(compact('produto'));

	}

	public function addcarrinho($id = null)
	{
		if (!$this->Produto->exists($id)) {
			throw new NotFoundException(__('Invalid compra'));
		}

		$carrinho = $this->Produto->addCarrinho($this->Cookie->read('carrinho'), $id);

		$this->Cookie->write('carrinho', $carrinho);

		if (!$this->request->is('ajax')){
			$this->Session->setFlash('Produto adicionado com sucesso');
			return $this->redirect(array('action'=>'carrinho'));
		}

		$this->set(compact('carrinho'));

		$this->render('carrinho_ajax');

	}

	public function menoscarrinho($id = null)
	{
		$carrinho = $this->Produto->menosCarrinho($this->Cookie->read('carrinho'), $id);
		if (!$carrinho) {
			throw new NotFoundException(__('Invalid compra'));
		}
		$this->Cookie->write('carrinho', $carrinho);

		if (!$this->request->is('ajax')){
			$this->Session->setFlash('Uma unidade removida com sucesso');
			return $this->redirect(array('action'=>'carrinho'));
		}

		$this->set(compact('carrinho'));
		$this->render('carrinho_ajax');
	}

	public function removecarrinho($id = null)
	{
		$carrinho = $this->Produto->removeCarrinho($this->Cookie->read('carrinho'), $id);
		if (!$carrinho) {
			throw new NotFoundException(__('Invalid compra'));
		}
		$this->Cookie->write('carrinho', $carrinho);

		if (!$this->request->is('ajax')){
			$this->Session->setFlash('Produto removido com sucesso');
			return $this->redirect(array('action'=>'carrinho'));
		}

		$this->set(compact('carrinho'));
		$this->render('carrinho_ajax');
	}

	public function carrinho($frete = 0, $dias = 0)
	{
		$carrinho = $this->Produto->listaCarrinho($this->Cookie->read('carrinho'), $frete);
		if ($frete != 0) $this->Cookie->write('carrinho', $carrinho);

		$this->set(compact('carrinho'));
		$this->set('carrinho_on', false);
		if (empty($carrinho['produtos'])) {
			$this->render('carrinho_vazio');
		}
		$this->set(compact('frete','dias'));
	}

	/*public function frete($finalizar = false, $cep_destino = null)
	{
		if ($this->request->is('post')) {
			$data = $this->request->data;
			$peso = $this->Produto->peso($this->Cookie->read('carrinho'));
			if (empty($cep_destino)) $cep_destino = $data['Produto']['cep_destino'];
			$options = array(
				'cep_destino'=>$cep_destino,
				'servico'=>$data['Produto']['servico'],
				'peso'=>$peso,
			);

			$frete = $this->Produto->correios($options);
			$this->set(compact('frete'));
		}
		if ($finalizar) {
			
			$this->render('confirmar');
		}
	}*/

	public function frete($finalizar = false)
	{
		if ($this->request->is('post')) {
			$data = $this->request->data;
			$peso = $this->Produto->peso($this->Cookie->read('carrinho'));
			$options = array(
				'cep_destino'=>$cep_destino,
				'servico'=>$data['Produto']['servico'],
				'peso'=>$peso,
			);

			$frete = $this->Produto->correios($options);
			$this->set(compact('frete'));
		}
	}

/**
 * index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Produto->recursive = 0;
		$this->set('produtos', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Produto->exists($id)) {
			throw new NotFoundException(__('Invalid produto'));
		}
		$options = array('conditions' => array('Produto.' . $this->Produto->primaryKey => $id));
		$this->set('produto', $this->Produto->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Produto->create();
			if ($this->Produto->save($this->request->data)) {
				$this->Session->setFlash(__('The produto has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The produto could not be saved. Please, try again.'));
			}
		}
		$parentProdutos = $this->Produto->ParentProduto->find('list');
		$usuarios = $this->Produto->Usuario->find('list');
		$categorias = $this->Produto->Categoria->find('list');
		$compras = $this->Produto->ComprasProduto->Compra->find('list');
		$this->set(compact('parentProdutos', 'usuarios', 'categorias', 'compras'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Produto->exists($id)) {
			throw new NotFoundException(__('Invalid produto'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Produto->save($this->request->data)) {
				$this->Session->setFlash(__('The produto has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The produto could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Produto.' . $this->Produto->primaryKey => $id));
			$this->request->data = $this->Produto->find('first', $options);
		}
		$parentProdutos = $this->Produto->ParentProduto->find('list');
		$usuarios = $this->Produto->Usuario->find('list');
		$categorias = $this->Produto->Categoria->find('list');
		$compras = $this->Produto->ComprasProduto->Compra->find('list');
		$this->set(compact('parentProdutos', 'usuarios', 'categorias', 'compras'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Produto->id = $id;
		if (!$this->Produto->exists()) {
			throw new NotFoundException(__('Invalid produto'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Produto->delete()) {
			$this->Session->setFlash(__('The produto has been deleted.'));
		} else {
			$this->Session->setFlash(__('The produto could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
