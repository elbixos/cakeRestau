<!-- File: /app/View/Products/index.ctp -->

<?
	//php print_r ($produits); ?> 


<h1>Produits</h1>
<table>
	<tr>
		<th>nom</th>
		<th>gamme</th>
		<th>Ingrédients</th>
		<th>action</th>
	</tr>

	<!-- Ici, la boucle sur les produits...en affichant les infos relatives au produit -->
	<?php foreach ($produits as $unProduit): ?>
	<tr>
		<td><?php echo $unProduit['ProductLine']['nom']; ?></td>
		<td><?php echo $unProduit['Product']['nom']; ?></td>
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
			//echo "rien";
			echo $this->Html->link(
				'Edit',
				array('action' => 'edit', $unProduit['Product']['id'])
			);
			?>
		</td>
	</tr>
	<?php endforeach; ?>
	<?php unset($unProduit); ?>
</table>

<?php
	echo $this->Html->link(
		'Ajout produit',
		array('controller' => 'products', 'action' => 'add')
	);
?>
<p>
<?php
	echo $this->Html->link(
		'Retour aux Gammes de produits',
		array('controller' => 'product_lines', 'action' => 'index')
	);
?>
</p>