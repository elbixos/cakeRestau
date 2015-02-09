<!-- File: /app/View/ProductLine/index.ctp -->
<h1>Gammes de produits</h1>
<table>
	<tr>
		<th>nom</th>
		<th>action</th>
	</tr>

	<!-- Here is where we loop through our $posts array, printing out post info -->
	<?php foreach ($product_lines as $uneGamme): ?>
	<tr>
		<td>
			<?php
			//echo $uneGamme['ProductLine']['nom'];
			echo '<p>';
			echo $this->Html->link($uneGamme['ProductLine']['nom'],
					array('controller' => 'products', 'action' => 'viewProductsFromProductLine' , $uneGamme['ProductLine']['id']));
			echo '</p>';
			echo '<p class ="imgProduct">';
				echo $this->Html->image('uploads/product_lines/' . $uneGamme['ProductLine']['image']);
			echo '</p>';
			?>
		</td>
		<td>
			<?php
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
			?>
		</td>
	</tr>
	<?php endforeach; ?>
	<?php unset($unIngredient); ?>
	
	
</table>

<?php
	echo $this->Html->link(
		'Ajout Gamme de produit',
		array('controller' => 'product_lines', 'action' => 'add')
	);
?>

<p>
	<?php
		echo 
			$this->Html->link('Voir tous les produits',
				array('controller' => 'products', 'action' => 'index')); 
	?>
</p>