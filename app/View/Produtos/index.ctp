<?php

echo '<h3>EM DESTAQUE</h3>';
echo $this->element('produtos/grid',array('action'=>'destaque','qtd'=>6)/*, array('cache'=>'curto')*/);

echo '<h3>MAIS VENDIDOS</h3>';
echo $this->element('produtos/grid',array('action'=>'maisvendidos','qtd'=>6)/* , array('cache'=>'curto')*/);

echo '<h3>MAIS NOVOS</h3>';
echo $this->element('produtos/grid',array('action'=>'novos','qtd'=>6)/*, array('cache'=>'curto')*/);