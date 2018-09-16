<?php
if ($frete['Servicos']['cServico']['Erro']!=0) {
	echo '<h3>'.$frete['Servicos']['cServico']['MsgErro'].'</h3>';
	echo $this->Html->link('Voltar ao carrinho', '/produtos/carrinho', array('class'=>'btn btn-info'));
} else {
	echo '<p>Valor: R$ '.$frete['Servicos']['cServico']['Valor'].'</p>';
	echo '<p>Prazo: '.$frete['Servicos']['cServico']['PrazoEntrega'].' dia(s)</p>';
	echo '<p>Entrega em casa: '.$frete['Servicos']['cServico']['EntregaDomiciliar'].'</p>';
	echo '<p>Entrega aos sábados: '.$frete['Servicos']['cServico']['EntregaSabado'].'</p>';
	echo $this->Html->link('Voltar ao carrinho', '/produtos/carrinho/'.$frete['Servicos']['cServico']['Valor'].'/'.$frete['Servicos']['cServico']['PrazoEntrega'], array('class'=>'btn btn-info'));
}
?>