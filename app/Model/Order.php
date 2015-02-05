<?php
	class Order  extends AppModel {
		public $hasMany = array(
			'OrderElement' => array(
				'className' => 'OrderElement',
				'foreignKey' => 'order_id',
				'dependent' => true)
        );
		
		public $belongsTo = 'User';

		public $actsAs = array('Containable');

	
	}

?>