<!-- File: /app/View/Ingredients/index.ctp -->
<?php //debug($ingredients) ?>


<h1>Ingrédients</h1>
<table>
	<tr>
		<th>nom</th>
		<?php
		if ($myuser['role'] == 'admin') {
			echo '<th>Actions</th>';
		}
		?>
	</tr>

	<!-- Here is where we loop through our $posts array, printing out post info -->
	<?php foreach ($ingredients as $unIngredient): ?>
	<tr>
		<td><?php echo $unIngredient['Ingredient']['nom']; ?></td>
		<?php
		if ($myuser['role'] == 'admin') {
			echo '<td>';
			echo $this->Html->link('edit', array(
				'controller' => 'ingredients', 'action' => 'edit', $unIngredient['Ingredient']['id']
				)
			);
			echo ' / ';
			echo $this->Form->postLink('delete', array(
				'controller' => 'ingredients', 'action' => 'delete', $unIngredient['Ingredient']['id']
				)
			);

			echo '</td>';
		}
		?>
	</tr>
	<?php endforeach; ?>
	<?php unset($unIngredient); ?>
</table>

<?php
	if ($myuser['role'] === 'admin' || $myuser['role'] === 'gerant') {
		echo $this->Html->link(
			'Ajout ingrédient',
			array('controller' => 'ingredients', 'action' => 'add')
		);
	}
?>