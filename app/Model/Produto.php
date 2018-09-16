<?php
App::uses('AppModel', 'Model');
/**
 * Produto Model
 *
 * @property Produto $ParentProduto
 * @property Usuario $Usuario
 * @property Comentario $Comentario
 * @property Foto $Foto
 * @property Produto $ChildProduto
 * @property Categoria $Categoria
 * @property Compra $Compra
 */
class Produto extends AppModel {

/**
 * Behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'Tree',
		'Ws'
	);

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'titulo' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'slug' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'descricao_curta' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'valor' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'valor_desconto' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'destaque' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'vendas' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'peso' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'lft' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'rght' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'usuario_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ParentProduto' => array(
			'className' => 'Produto',
			'foreignKey' => 'parent_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Usuario' => array(
			'className' => 'Usuario',
			'foreignKey' => 'usuario_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Comentario' => array(
			'className' => 'Comentario',
			'foreignKey' => 'produto_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Foto' => array(
			'className' => 'Foto',
			'foreignKey' => 'produto_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ChildProduto' => array(
			'className' => 'Produto',
			'foreignKey' => 'parent_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ComprasProduto'
	);


/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Categoria' => array(
			'className' => 'Categoria',
			'joinTable' => 'categorias_produtos',
			'foreignKey' => 'produto_id',
			'associationForeignKey' => 'categoria_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)/*,
		'Compra' => array(
			'className' => 'Compra',
			'joinTable' => 'compras_produtos',
			'foreignKey' => 'produto_id',
			'associationForeignKey' => 'compra_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)*/
	);

/**
 * beforeSave callback
 *
 * @param $options array
 * @return boolean
 */
	public function beforeSave($options=array())
	{
		$this->zeracache();
		return true;
	}

	public function zeracache()
	{
		Cache::delete('produtos_destaque', 'curta');
		Cache::delete('produtos_maisvendidos', 'curta');
		Cache::delete('produtos_novos', 'curta');
	}

	public function destaque($limit = 6)
	{
		$retorno = Cache::read('produtos_destaque', 'curta');
		if (!$retorno) {
			$conditions = array(
				'Produto.destaque >' => 0
			);
			
			$order = 'Produto.created DESC';

			$retorno = $this->find('all',compact('conditions', 'order', 'limit'));

			Cache::write('produtos_destaque',$retorno, 'curta');
			
		}

		return $retorno;

	}

	public function maisvendidos($limit = 6)
	{
		$retorno = Cache::read('produtos_maisvendidos', 'curta');
		if (!$retorno) {
			
			$order = 'Produto.vendas DESC';

			$retorno = $this->find('all',compact('order', 'limit'));

			Cache::write('produtos_maisvendidos',$retorno, 'curta');
			
		}

		return $retorno;
	}

	public function novos($limit = 6)
	{
		$retorno = Cache::read('produtos_novos', 'curta');
		if (!$retorno) {
			
			$order = 'Produto.created DESC';

			$retorno = $this->find('all',compact('conditions', 'order', 'limit'));

			Cache::write('produtos_novos',$retorno, 'curta');
			
		}

		return $retorno;
	}

	public function addCarrinho($carrinho = array(), $produto_id)
	{
		if (empty($carrinho) or (!$carrinho)) {
			$carrinho = $this->criaCarrinho();
		}

		$produto = $this->getProduto($carrinho, $produto_id);
		$produto['Produto']['qtd']++;

		$carrinho['produtos'][$produto['Produto']['id']] = $produto;

		$carrinho = $this->frete($carrinho, $carrinho['frete']['frete']);

		return $carrinho;
	}

	public function menosCarrinho($carrinho = array(), $produto_id)
	{
		if (empty($carrinho) or (!$carrinho)) {
			$carrinho = $this->criaCarrinho();
		}
		if (!array_key_exists($produto_id, $carrinho['produtos'])) {
			return false;
		}
		if ($carrinho['produtos'][$produto_id]['Produto']['qtd'] > 1) {
			$carrinho['produtos'][$produto_id]['Produto']['qtd']--;
		} else {
			unset($carrinho['produtos'][$produto_id]);
		}
		$carrinho = $this->frete($carrinho, $carrinho['frete']['frete']);
		return $carrinho;
	}

	public function removeCarrinho($carrinho = array(), $produto_id)
	{
		if (empty($carrinho) or (!$carrinho)) {
			$carrinho = $this->criaCarrinho();
		}

		if (!array_key_exists($produto_id, $carrinho['produtos'])) {
			return false;
		}

		unset($carrinho['produtos'][$produto_id]);

		$carrinho = $this->frete($carrinho, $carrinho['frete']['frete']);

		return $carrinho;

	}

	public function listaCarrinho($carrinho = array(), $frete=0)
	{
		if (empty($carrinho) or (!$carrinho)) {
			$carrinho = $this->criaCarrinho();
		}
		if ($frete != 0) $carrinho = $this->frete($carrinho, $frete);

		/*if (empty($carrinho['produtos'])) {
			$carrinho['produtos'][0]['Produto']['titulo'] = 'Carrinho vazio';
			$carrinho['produtos'][0]['Produto']['qtd'] = 0;
			$carrinho['produtos'][0]['Produto']['valor'] = 0;
			$carrinho['produtos'][0]['Produto']['id'] = 0;
		}*/

		return  $carrinho;

	}

	public function peso($carrinho = array())
	{
		$total = 0;
		foreach($carrinho['produtos'] as $produto) {
			if (!isset($produto['Produto']))
				$produto['Produto']['peso'] = $produto['peso'];
			$total = $total+$produto['Produto']['peso'];
		}
		return $total;
	}

	private function criaCarrinho()
	{
		$carrinho = array(
			'produtos'=>array(),
			'frete'=>array(
				'total'=>0,
				'frete'=>0,
				'total_geral'=>0,
			)
		);

		return $carrinho;
	}

	public function frete($carrinho = array(), $frete=0)
	{
		$total = 0;
		$frete = str_replace(',', '.', $frete);
		foreach($carrinho['produtos'] as $v) {
			$total = $total+($v['Produto']['valor']*$v['Produto']['qtd']);
		}
		$carrinho['frete']=array(
			'total'=>$total,
			'frete'=>$frete,
			'total_geral'=>$total+$frete
		);
		
		return $carrinho;
	}

	protected function getProduto($carrinho, $produto_id)
	{
		$conditions = array(
			'Produto.id' => $produto_id,
		);
		$recursive = -1;
		$fields = array(
			'Produto.id',
			'Produto.titulo',
			'Produto.slug',
			'Produto.valor',
			'Produto.peso',
		);
		$produto = $this->find('first', compact('conditions', 'recursive', 'fields'));


		if (array_key_exists($produto['Produto']['id'], $carrinho['produtos'])) {
			$produto['Produto']['qtd'] = $carrinho['produtos'][$produto['Produto']['id']]['Produto']['qtd'];
		} else {
			$produto['Produto']['qtd'] = 0;
		}

		return $produto;
	}

}
