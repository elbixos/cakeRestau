<!-- File: /app/View/Orders/index.ctp -->
<h1>Commandes</h1>

<?php debug($orders); ?>

<table>
	<tr>
		<th>id</th>
		<th>Nom du client</th>
		<th>Produits</th>
		<th>action</th>
	</tr>

	<!-- Here is where we loop through our $posts array, printing out post info -->
	<?php foreach ($orders as $order): ?>
	<tr>
		<td> <?php echo $order['Order']['id']; ?> </td>
		<td>
		<?php
				echo $order['User']['username'];
			
		?>
		</td>
		<td>
			<table>
		<?php
			foreach ($order['OrderElement'] as $orderElement) {
				echo '<tr>';
				echo '<td>';
				echo $orderElement['Product']['ProductLine']['nom'].' / '.$orderElement['Product']['nom'];
				echo '</td>';
				echo '<td>'.$orderElement['etat'].'<td>';
				echo '<td>';
				echo $this->Form->postLink(
					'Avancer',
					array('controller'=> 'OrderElements','action' => 'avancer', $orderElement['id'])
				);
				echo '<td>';
				echo '</tr>';
			}
		?>
			</table>
		</td>
		<td>
			<?php 
			//echo "rien";
			echo $this->Form->postLink(
					'Supprimer',
					array('action' => 'delete', $order['Order']['id']),
					array('confirm' => 'Are you sure?')
				);
			/*$this->Html->link($post['Post']['title'],
			array('controller' => 'posts', 'action' => 'view', $post['Post']['id']));
			*/?>
		</td>
	</tr>
	<?php endforeach; ?>
	<?php unset($orders); ?>
</table>
