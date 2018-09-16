<?php
	$status = array(
		'Pedido de pagamento pendente',
		'Aguardando pagamento',
		'Em análise',
		'Paga',
		'Disponível',
		'Em disputa',
		'Devolvida',
		'Cancelada',
	);
?><h3>Minhas compras</h3>

<table class="table table-hover table-striped">
	<thead>
		<tr>
			<th>Data</th>
			<th>Valor</th>
			<th>Valor do frete</th>
			<th>Status</th>
			<th>Ações</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($compras as $compra):?>
		<tr>
			<td><?php echo $this->Time->format($compra['Compra']['created'], '%B %e, %Y');?></td>
			<td>R$ <?php echo $compra['Compra']['valor'];?></td>
			<td>R$ <?php echo $compra['Compra']['valor_frete'];?></td>
			<td><?php
				$conta_status = count($compra['Notificacao']);
				if ($conta_status>0) {
					echo $status[$compra['Notificacao'][$conta_status-1]['status']];
				} else {
					echo $status[0];
				}
			?></td>
			<th>
				<?php echo $this->Html->link('Ver produtos', array('action'=>'ver', $compra['Compra']['id']), array('class'=>'btn btn-default btn-xs'));?>

				<?php echo $this->Html->link('pagar', array('action'=>'confirmar', $compra['Compra']['id']), array('class'=>'btn btn-success btn-xs'));?>
			</th>
		</tr>
	<?php endforeach;?>
	</tbody>
</table>