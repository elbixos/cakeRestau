<!-- File: /app/View/Products/index.ctp -->

<?
	//php print_r ($produits); ?> 


<h1>Produits</h1>
<table>
	<tr>
		<th>Gamme</th>
		<th>Nom</th>
		<th>Prix</th>
		<th>Ingrédients</th>
		<th>action</th>
	</tr>

	<!-- Ici, la boucle sur les produits...en affichant les infos relatives au produit -->
	<?php foreach ($produits as $unProduit): ?>
	<tr>
		<td><?php echo $unProduit['ProductLine']['nom']; ?></td>
		<td><?php echo $unProduit['Product']['nom']; ?></td>
		<td><?php echo $this->Html->image('uploads/products/' . $unProduit['Product']['image']); ?></td>
		<td><?php echo $unProduit['Product']['prix']; ?></td>
		<td>
			<?php
			$ingredients = $unProduit['Ingredient'];
			foreach ($ingredients as $unIngredient) :
				echo $unIngredient["nom"]. ', ' ;
			endforeach;
			?>
		</td>
		<td>
	
            <?php echo $this->Form->create('Cart',array('id'=>'add-form','url'=>array('controller'=>'carts','action'=>'add')));?>
            <?php echo $this->Form->hidden('product_id',array('value'=>$unProduit['Product']['id']))?>
            <?php echo $this->Form->submit('Add to cart',array('class'=>'btn-success btn btn-lg'));?>
            <?php echo $this->Form->end();?>
        
			<?php
			//ajout des liens edit/delete
			if ($myuser['role'] === 'admin' || $myuser['role'] === 'gerant') {
				echo $this->Html->link(
					'Edit',
					array('action' => 'edit', $unProduit['Product']['id'])
				);
				echo ' / ';
				echo $this->Form->postLink(
					'Delete',
					array('action' => 'delete', $unProduit['Product']['id'])
				);
			}
			?>
		</td>
	</tr>
	<?php endforeach; ?>
	<?php unset($unProduit); ?>
</table>

<?php
	
	if ($myuser['role'] === 'admin' || $myuser['role'] === 'gerant') {
		echo '<p>';
		echo $this->Html->link(
			'Ajout produit',
			array('controller' => 'products', 'action' => 'add')
		);
		echo '</p>';
	}
?>
