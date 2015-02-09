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
	
	echo $this->Form->create('Product', array('enctype' => 'multipart/form-data'));
	echo $this->Form->input('product_line_id');
	echo $this->Form->input('nom');
	if (!empty ($this->request->data['Product']['image'])){
		echo '<p class="imgProduct">';
		echo $this->Html->image('uploads/products/' . $this->request->data['Product']['image']);
		echo '</p>';
	}
	echo $this->Form->input('Modifier image', array('type' => 'file'));

	echo $this->Form->input('prix');
	echo $this->Form->input('Ingredient',array( 'type' => 'select', 'multiple' => 'checkbox' ));

	echo $this->Form->end('Modifier le produit');

?>