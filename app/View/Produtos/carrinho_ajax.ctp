	<thead>
		<tr>
			<th>Produto</th>
			<th>&nbsp;</th>
			<th>R$</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($carrinho['produtos'] as $v): ?>
		<tr>
			<td><?php echo $v['Produto']['titulo'];?></td>
			<td>
				<?php echo $v['Produto']['qtd'];?> unidades - 
				<?php echo $this->Html->link('+', '/produtos/addcarrinho/'.$v['Produto']['id'], array('class'=>'btn btn-info btn-xs'));?>
				<?php echo $this->Html->link('-', '/produtos/menoscarrinho/'.$v['Produto']['id'], array('class'=>'btn btn-warning btn-xs'));?>
				<?php echo $this->Html->link('<span class="glyphicon glyphicon-trash"></span>', '/produtos/removecarrinho/'.$v['Produto']['id'], array('class'=>'btn btn-danger btn-xs', 'escape'=>false));?>
			</td>
			<td><?php echo $v['Produto']['valor'];?></td>
		</tr>
	<?php endforeach;?>
	<tbody>
		<tr>
			<th>&nbsp;</th>
			<th>Total</th>
			<th><?php echo $carrinho['frete']['total'];?></th>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<th>Frete</th>
			<th><?php echo $carrinho['frete']['frete'];?></th>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<th>Total geral</th>
			<th><?php echo $carrinho['frete']['total_geral'];?></th>
		</tr>
	</tbody>
	</tbody>