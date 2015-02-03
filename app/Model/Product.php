<?php
	class Product  extends AppModel {
		public $hasAndBelongsToMany = array(
			'Ingredient' =>
				array(
					'className' => 'Ingredient',
					'joinTable' => 'ingredients_products',
					'foreignKey' => 'product_id',
					'associationForeignKey' => 'ingredient_id',
					'unique' => true,
					'conditions' => '',
					'fields' => '',
					'order' => '',
					'limit' => '',
					'offset' => '',
					'finderQuery' => ''
				)
		);
		
		public $belongsTo = 'ProductLine';
			
	}

?>