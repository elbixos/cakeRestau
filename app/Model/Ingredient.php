<?php
	class Ingredient  extends AppModel {
		public $validate = array(
			'nom' => array(
				'rule' => 'notEmpty'
			)
		);
	}

?>