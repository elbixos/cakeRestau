<!-- File: /app/View/ProductLines/edit.ctp -->
<h1>Modification d'un produit</h1>
<?php
	
	
	//debug($dbg);
	
	
	echo $this->Form->create('ProductLine', array('enctype' => 'multipart/form-data'));
	echo $this->Form->input('nom');
	if (!empty ($this->request->data['ProductLine']['image'])){
		echo '<p class="imgProduct">';
		echo $this->Html->image('uploads/product_lines/' . $this->request->data['ProductLine']['image']);
		echo '</p>';
	}
	echo $this->Form->input('Modifier image', array('type' => 'file'));

	echo $this->Form->end('Modifier le produit');

?>