<!-- File: /app/View/Products/add.ctp -->
<h1>Ajout d'un produit</h1>
<?php

	debug($productLines);
	debug($ingredients);
	// creation du formulaire, enctype pour l'upoad d'images
	echo $this->Form->create('Product', array('enctype' => 'multipart/form-data'));
	echo $this->Form->input('nom');
	echo $this->Form->input('product_line_id');
	// le champ pour l'upload...
	echo $this->Form->input('upload', array('type' => 'file'));
	echo $this->Form->input('Ingredient',array( 'type' => 'select', 'multiple' => 'checkbox' ));
	echo $this->Form->input('prix');
	echo $this->Form->end('Ajouter le produit');

?>