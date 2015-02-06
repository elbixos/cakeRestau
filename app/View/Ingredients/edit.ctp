<!-- File: /app/View/Ingredients/edit.ctp -->
<h1>Modification d'un Ingrédient</h1>
<?php
echo $this->Form->create('Ingredient');
echo $this->Form->input('nom');
echo $this->Form->end('Modifier l\'ingrédient');
?>