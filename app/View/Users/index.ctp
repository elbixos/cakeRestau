<!-- File: /app/View/Products/index.ctp -->

<?
	//php print_r ($produits); ?> 


<h1>Utilisateurs</h1>
<table>
	<tr>
		<th>nom</th>
		<th>Role</th>
		<th>email</th>
		<th>action</th>
	</tr>

	<!-- Ici, la boucle sur les produits...en affichant les infos relatives au produit -->
	<?php foreach ($users as $user): ?>
	<tr>
		<td><?php echo $user['User']['username']; ?></td>
		<td><?php echo $user['User']['role']; ?></td>
		<td><?php 	
				echo $this->Html->link(
					'Edit',
					array('action' => 'edit', $user['User']['id'])
				);
			?>
		</td>
		
	</tr>
	<?php endforeach; ?>
	<?php unset($users); ?>
</table>

<?php
	echo "utilisateur : ".$myuser['username'];
?>

