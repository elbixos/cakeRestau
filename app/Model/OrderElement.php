<?php
	class OrderElement  extends AppModel {
		
		public $belongsTo = array (
			'Order' => array (
				'foreignKey' => 'order_id'
			),
			'Product' => array (
				'foreignKey' => 'product_id'
			)   
		);
		
	}

?>