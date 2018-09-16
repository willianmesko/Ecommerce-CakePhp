<h3>Seu carrinho de compras</h3>

<table class="carrinho table table-striped table-hover">
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
			<th>R$ <?php echo number_format($carrinho['frete']['total'], 2);?></th>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<th>Frete</th>
			<th>R$ <?php echo number_format($carrinho['frete']['frete'], 2);?></th>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<th>Total geral</th>
			<th>R$ <?php echo number_format($carrinho['frete']['total_geral'], 2);?></th>
		</tr>
	</tbody>
	</tbody>
</table>
<?php if ($dias > 0): ?><p>O prazo de entrega previsto pelos correios é de <?php echo $dias;?> dia(s) a partir da data de postagem.</p><?php endif;?>
<hr/>
<p>
	<?php echo $this->Html->link('Continuar comprando', '/', array('class'=>'btn btn-info'));?>
</p>
<hr/>
<h3>Consulte o CEP</h3>
<?php
	echo $this->Form->create('Produto', array('id'=>'frete_form', 'action'=>'frete', 'role'=>'form',
			'class'=>'form-horizontal col-md-6',
			'inputDefaults'=>array(
				'before'=>'<div class="form-group">',
				'between'=>'<div class="col-sm-10">',
				'after'=>'</div></div>',
				'class'=>'form-control',
				'label'=>array(
					'class'=>'col-sm-2 control-label',
				)
			)));
	echo $this->Form->input('servico', array('options'=>array(
		40010=>'Sedex',
		41106=>'Pac',
	)));
	echo $this->Form->input('cep_destino', array('label'=>array('class'=>'col-sm-2 control-label', 'text'=>'CEP')));
	echo $this->Form->end('Consultar');
?>

<?php

echo $this->Html->scriptBlock('
	$(function(){
		$(".carrinho").on("click", "a", function(){
			var carrinho = $(this);
			$.ajax({
				"url":carrinho.attr("href"),
				"success":function(data){
					$(".carrinho").html(data);
				}
			});
			return false;
		});
		/*$("#frete_form").submit(function(){
			var form = $(this);
			$.ajax({
				"url":form.attr("action"),
				"dataType":"json",
				"type":"post",
				"data":form.serialize(),
				"success":function(data){
					console.log(data);
				}
			});
			return false;
		});*/
	});
', array('inline'=>false));?>
