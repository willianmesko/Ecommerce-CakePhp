<?php
/*
if ($frete['Servicos']['cServico']['Erro']!=0) {
	echo '<h3>'.$frete['Servicos']['cServico']['MsgErro'].'</h3>';
	echo $this->Html->link('Voltar ao carrinho', '/produtos/carrinho', array('class'=>'btn btn-info'));
} else {
	echo 'h3{Confirme sua compra}';
	echo '<h4>frete</h4>';
	echo '<p>Valor: R$ '.$frete['Servicos']['cServico']['Valor'].'</p>';
	echo '<p>Prazo: '.$frete['Servicos']['cServico']['PrazoEntrega'].' dia(s)</p>';
	echo '<p>Entrega em casa: '.$frete['Servicos']['cServico']['EntregaDomiciliar'].'</p>';
	echo '<p>Entrega aos sábados: '.$frete['Servicos']['cServico']['EntregaSabado'].'</p>';
	echo '<h4>Produtos</h4>';
	echo '<ul>';
	foreach($carrinho['produtos'] as $k=>$v) {
		echo '<li>'.$v['Produto']['titulo'].' - '.$v['Produto']['qtd'].'und - R$'.$v['Produto']['valor'];
	}
	echo '</ul>';
} */
?>

<h3>Confirme sua compra</h3>
<ul>
	<li>Total: R$ <?php echo number_format($total['produtos'], 2);?></li>
	<li>Frete: R$ <?php echo $frete['Servicos']['cServico']['Valor'];?></li>
	<li>Total geral: R$ <?php echo number_format($total['geral'], 2);?></li>
</ul>
<p>
	<?php echo $this->Html->link("Ir para o pagamento", $pagseguro, array('class'=>'btn btn-success btn-lg', 'target'=>'_blank'));?>
</p>