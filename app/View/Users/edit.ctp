<!-- File: /app/View/Users/edit.ctp -->
<h1>Modification d'un Utilisateur</h1>
<?php
	
	
	echo $this->Form->create('User');
	echo $this->Form->input('username');
	//echo $this->Form->input('password');

	$roles = array('admin'=>'Admin','gérant' => 'Gérant','cuisinier'=> 'Cuisinier','livreur' => 'Livreur','client'=>'Client');
	echo $this->Form->input('role',array('options'=> $roles));
	

	echo $this->Form->end('Modifier l utilisateur');

?>