<h3>Compra realizada em <?php echo $this->Time->format($compra['Compra']['created'], '%B %e, %Y');?></h3>

<table class="table table-hover table-striped">
	<thead>
		<tr>
			<th>#</th>
			<th>titulo</th>
			<th>valor</th>
			<th>qtd</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($compra['ComprasProduto'] as $k => $produto):?>
		<tr>
			<td><?php $k++;echo $k;?></td>
			<td><?php
				echo $this->Html->link($produto['Produto']['titulo'], '/produto/'.$produto['Produto']['slug']);
			?></td>
			<td>R$ <?php echo $produto['Produto']['valor'];?></td>
			<td><?php echo $produto['qtd'];?></td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>

<hr>

<?php
	echo $this->Html->link('Minhas compras', '/cliente/compras', array('class'=>'btn btn-primary btn-lg'));
?>