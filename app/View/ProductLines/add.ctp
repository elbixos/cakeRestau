<!-- File: /app/View/Ingredients/add.ctp -->
<h1>Ajout d'une gamme de produits</h1>
<?php
echo $this->Form->create('ProductLine');
echo $this->Form->input('nom');
echo $this->Form->end('Ajouter la gamme de produits');
?>