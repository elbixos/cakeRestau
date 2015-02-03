<!-- File: /app/View/Products/add.ctp -->
<h1>Ajout d'un produit</h1>
<?php
	
	/*
	print_r($product_lines)
	foreach ($product_lines as $product_line) :
		echo $product_line['ProductLine']['nom'];
	endforeach;
	*/
	debug($productLines);
	debug($ingredients);
	echo $this->Form->create('Product');
	echo $this->Form->input('nom');
	echo $this->Form->input('product_line_id');
	echo $this->Form->input('Ingredient',array( 'type' => 'select', 'multiple' => 'checkbox' ));

	echo $this->Form->end('Ajouter le produit');

?>