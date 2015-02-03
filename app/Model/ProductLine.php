<?php
	class ProductLine  extends AppModel {
		public $hasMany =
			array(
			'Product' => array(
				'className' => 'Product',
				'dependent' => true
				)
			);
			
	}

?>