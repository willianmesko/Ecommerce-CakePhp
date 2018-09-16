<h3>Confira seus dados</h3>

<?php
	echo $this->Form->create('Compra', array(
			'role'=>'form',
			'class'=>'form-horizontal',
			'inputDefaults'=>array(
				'before'=>'<div class="form-group">',
				'between'=>'<div class="col-sm-10">',
				'after'=>'</div></div>',
				'class'=>'form-control',
				'label'=>array(
					'class'=>'col-sm-2 control-label',
				)
			)
		)
	);
	echo $this->Form->input('Usuario.nome');
	echo $this->Form->input('Usuario.email');
	echo $this->Form->input('cep');
	echo $this->Form->input('endereco');
	echo $this->Form->input('bairro');
	echo $this->Form->input('cidade');
	echo $this->Form->input('estado');
	echo $this->Form->input('tipo_entrega', array(
			'options'=>array(
				40010=>'Sedex',
				41106=>'Pac',
			),
			'label'=>array(
				'class'=>'col-sm-2 control-label',
				'text'=>'Serviço de entrega'
			)
		)
	);
	echo $this->Form->input('usuario_id', array('type'=>'hidden'));
	echo $this->Form->input('Salvar', array(
		'type'=>'submit',
		'class'=>'btn btn-success',
		'between'=>'<div class="col-sm-offset-2 col-sm-10">',
		'label'=>false
	));
	echo $this->Form->end();
?>