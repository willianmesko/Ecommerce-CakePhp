<div id="carrinho">
    <p class="btn-titulo text-right">Você <span class="produtos-conta">não tem produtos</span> aqui!</p>
    <div class="dropdown">
        <div class="alert alert-info">
            Arraste um produto para cá!
        </div>
        <nav>
            <ul class="produtos-carrinho">
            </ul>
        </nav>
        <p class="text-center">
            <?php echo $this->Html->link('Ir para o carrinho','/produtos/carrinho',array('class'=>'btn btn-success'));?>
            <?php echo $this->Html->link('Finalizar compra','/compras/finalizar',array('class'=>'btn btn-warning'));?>
        </p>
    </div>
</div>