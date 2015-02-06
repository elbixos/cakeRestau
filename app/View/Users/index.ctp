<!-- File: /app/View/Users/index.ctp -->

<?php
//debug ($users); 
//debug ($myuser); 

?> 


<h1>Utilisateurs</h1>
<table>
	<tr>
		<th>nom</th>
		<th>Role</th>
		<th>email</th>
		<th>actions</th>
	</tr>

	<!-- Ici, la boucle sur les produits...en affichant les infos relatives au produit -->
	<?php foreach ($users as $user): ?>
	<tr>
		<td><?php echo $user['User']['username']; ?></td>
		<td><?php echo $user['User']['role']; ?></td>
		<td><?php echo $user['User']['email']; ?></td>
		<td><?php
			if ($myuser['role'] === 'admin' || $myuser['role'] === 'gerant') {
				
				echo $this->Html->link(
					'Edit',
					array('action' => 'edit', $user['User']['id'])
				);
				echo " / ";
				echo $this->Form->postLink(
					'Supprimer',
					array('action' => 'delete', $user['User']['id'])
				);
			}
			?>
		</td>
		
	</tr>
	<?php endforeach; ?>
	<?php unset($users); ?>
</table>


