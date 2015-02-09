<!-- File: /app/View/Products/edit.ctp -->
<h1>Modification d'un produit</h1>
<?php
	
	
	//debug($dbg);
	
	
	echo $this->Form->create('ProductLine', array('enctype' => 'multipart/form-data'));
	echo $this->Form->input('nom');
	echo $this->Form->input('upload', array('type' => 'file'));

	echo $this->Form->end('Modifier le produit');

?>