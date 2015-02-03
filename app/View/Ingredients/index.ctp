<!-- File: /app/View/Ingredients/index.ctp -->
<?php debug($ingredients) ?>


<h1>Ingrédients</h1>
<table>
	<tr>
		<th>nom</th>
		<th>action</th>
	</tr>

	<!-- Here is where we loop through our $posts array, printing out post info -->
	<?php foreach ($ingredients as $unIngredient): ?>
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