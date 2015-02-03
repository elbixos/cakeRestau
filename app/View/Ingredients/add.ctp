<!-- File: /app/View/Ingredients/add.ctp -->
<h1>Ajout d'un Ingrédient</h1>
<?php
echo $this->Form->create('Ingredient');
echo $this->Form->input('nom');
echo $this->Form->end('Ajouter l ingrédient');
?>