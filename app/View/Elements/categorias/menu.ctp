<?php $menu = $this->requestAction('categorias/menu');?>
<nav class="vertical">
    <ul>
    <?php foreach($menu as $k => $v): ?>
        <li><?php echo $this->Html->link($v,'/categoria/'.$k);?></li>
    <?php endforeach;?>
    </ul>
</nav>