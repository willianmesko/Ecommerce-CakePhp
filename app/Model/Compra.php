<?php
App::uses('AppModel', 'Model');
/**
 * Compra Model
 *
 * @property Usuario $Usuario
 * @property Notificacao $Notificacao
 * @property Produto $Produto
 */
class Compra extends AppModel {

	public $actsAs = array(
		'Ws',
		'Containable'
	);

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'cep' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'endereco' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'bairro' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'cidade' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'estado' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
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
		'Notificacao' => array(
			'className' => 'Notificacao',
			'foreignKey' => 'compra_id',
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
 *
 *	public $hasAndBelongsToMany = array(
 *		'Produto' => array(
 *			'className' => 'Produto',
 *			'joinTable' => 'compras_produtos',
 *			'foreignKey' => 'compra_id',
 *			'associationForeignKey' => 'produto_id',
 *			'unique' => 'keepExisting',
 *			'conditions' => '',
 *			'fields' => '',
 *			'order' => '',
 *			'limit' => '',
 *			'offset' => '',
 *			'finderQuery' => '',
 *		)
 *	);
 */

	public function getCompra($id = null)
	{
		$conditions = array(
			'Compra.id'=>$id
		);

		$contain = array(
			'ComprasProduto'=>array(
				'Produto'=>array(
					'fields'=>array('Produto.id', 'Produto.titulo', 'Produto.slug', 'Produto.valor')
				)
			)
		);

		return $this->find('first', compact('conditions', 'contain'));
	}

	public function formataDados($user_id)
	{
		$usuario = $this->Usuario->find('first', array('conditions'=>$user_id));
		$request['Compra'] = $usuario['Usuario'];
		unset($request['Compra']['id']);
		unset($request['Compra']['nome']);
		$request['Compra']['usuario_id'] = $usuario['Usuario']['id'];
		$request['Usuario']['nome'] = $usuario['Usuario']['nome'];
		$request['Usuario']['email'] = $usuario['Usuario']['email'];
		return $request;
	}

	public function relacionaProduto($produtos)
	{
		$retorno = array();
		foreach($produtos as $k => $produto)
		{
			$retorno[$k]['produto_id'] = $produto['Produto']['id'];
			$retorno[$k]['qtd'] = $produto['Produto']['qtd'];
		}
		return $retorno;
	}

	public function totalCompra($compra){
		$total = 0;
		foreach($compra as $k=>$v) {
			$total += $v['Produto']['valor'];
		}
		return $total;
	}

}
