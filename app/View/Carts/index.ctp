<!-- File: /app/View/Carts/index.ctp -->
<h1>Panier</h1>

<?php print_r ($cart); ?>

<table>
	<tr>
		<th>nom</th>
		<th>action</th>
	</tr>

	<!-- Here is where we loop through our $posts array, printing out post info -->
	<?php foreach ($carts as $cart): ?>
	<tr>
		<td><?php echo $unIngredient['Ingredient']['nom']; ?></td>
		<td>
			<?php echo "rien";
			/*$this->Html->link($post['Post']['title'],
			array('controller' => 'posts', 'action' => 'view', $post['Post']['id']));
			*/?>
		</td>
	</tr>
	<?php endforeach; ?>
	<?php unset($unIngredient); ?>
</table>

<?php
	echo $this->Html->link(
		'Ajout ingrédient',
		array('controller' => 'ingredients', 'action' => 'add')
	);
?>