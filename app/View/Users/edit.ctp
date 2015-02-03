<!-- File: /app/View/Users/edit.ctp -->
<h1>Modification d'un Utilisateur</h1>
<?php
	
	
	echo $this->Form->create('User');
	echo $this->Form->input('username');
		echo $this->Form->input('password');

	echo $this->Form->input('role');
	

	echo $this->Form->end('Modifier l utilisateur');

?>