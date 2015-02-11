<!-- File: /app/View/ProductLine/index.ctp -->
<h1>Gammes de produits</h1>

<!-- Here is where we loop through our $posts array, printing out post info -->
<?php
if (!empty($product_lines)) {
	echo '<ul class="prodLines">';
	foreach ($product_lines as $uneGamme){
		echo '<li>';
		
		
		//echo $uneGamme['ProductLine']['nom'];
		echo '<p>';
		echo $this->Html->link($uneGamme['ProductLine']['nom'],
				array('controller' => 'products', 'action' => 'viewProductsFromProductLine' , $uneGamme['ProductLine']['id']));
		echo '</p>';
		echo '<p class ="imgProduct">';
			echo $this->Html->image('uploads/product_lines/' . $uneGamme['ProductLine']['image']);
		echo '</p>';
		echo '<p class="testclick" product_line_id="'.$uneGamme['ProductLine']['id'].'" >';
		echo 'Voir';
		echo '</p>';
		// Controles Edit / Delete pour admin et gerant
		if ($myuser['role'] === 'admin' || $myuser['role'] === 'gerant') {
			echo '<p>';
			echo $this->Form->postLink(
				'Supprimer',
				array('action' => 'delete', $uneGamme['ProductLine']['id']),
				array('confirm' => 'Are you sure?')
			);
			echo ' / ';
		
			echo $this->Html->link(
				'Edit',
				array('action' => 'edit', $uneGamme['ProductLine']['id'])
			);
			echo '</p>';
		}
		echo '</li>';

	}
	
	echo '</ul>';
}

unset($unIngredient); ?>

<?php
if ($myuser['role'] === 'admin' || $myuser['role'] === 'gerant') {
	echo $this->Html->link(
		'Ajout Gamme de produit',
		array('controller' => 'product_lines', 'action' => 'add')
	);
}
?>
<div id="listeProdFromProductLine">
</div>


<?php echo $this->Html->script("myAjax"); ?>

