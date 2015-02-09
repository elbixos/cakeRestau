<!-- File: /app/View/Ingredients/add.ctp -->
<h1>Ajout d'une gamme de produits</h1>
<?php
// enctype pour l'upload de fichier
echo $this->Form->create('ProductLine', array('enctype' => 'multipart/form-data'));

echo $this->Form->input('nom');
// le champ pour l'upload...
echo $this->Form->input('upload', array('type' => 'file'));
echo $this->Form->end('Ajouter la gamme de produits');
?>