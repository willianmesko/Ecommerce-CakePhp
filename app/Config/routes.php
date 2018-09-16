<?php
	Router::parseExtensions('json');

	Router::connect('/', array('controller' => 'produtos', 'action' => 'index'));
	Router::connect('/admin', array('prefix'=>'admin','admin'=>true,'controller' => 'produtos', 'action' => 'index'));

	Router::connect('/produto/:slug',array('controller'=>'produtos','action'=>'ver'), array('pass'=>array('slug')));
	Router::connect('/categoria/:slug',array('controller'=>'categorias','action'=>'ver'), array('pass'=>array('slug')));

	Router::connect('/cliente',array('controller'=>'usuarios','action'=>'index'));
	Router::connect('/cliente/compras',array('controller'=>'compras'));
	Router::connect('/cliente/:action',array('controller'=>'usuarios'));
	Router::connect('/cliente/:action/*',array('controller'=>'usuarios'));

	Router::connect('/pages/enviaremail', array('controller' => 'pages', 'action' => 'enviaremail'));
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

	CakePlugin::routes();

	require CAKE . 'Config' . DS . 'routes.php';
