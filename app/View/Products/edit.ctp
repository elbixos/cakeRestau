<!-- File: /app/View/Products/edit.ctp -->
<h1>Modification d'un produit</h1>
<?php
	
	/*
	print_r($product_lines)
	foreach ($product_lines as $product_line) :
		echo $product_line['ProductLine']['nom'];
	endforeach;
	
	echo "<br>";
	print_r($productLines);
	
	print_r($ingredients);

	*/
	
	echo $this->Form->create('Product');
	echo $this->Form->input('product_line_id');
	echo $this->Form->input('nom');
	echo $this->Form->input('prix');
	echo $this->Form->input('Ingredient',array( 'type' => 'select', 'multiple' => 'checkbox' ));

	echo $this->Form->end('Modifier le produit');

?>