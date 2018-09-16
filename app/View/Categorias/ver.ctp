<h3><?php echo $categoria['Categoria']['titulo'];?></h3>

<?php echo $this->element('produtos/grid',array('produtos'=>$categoria['Produto']));?>