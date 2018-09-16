<?php

class ComprasProduto extends AppModel
{
	public $belongsTo = array('Produto', 'Compra');
}