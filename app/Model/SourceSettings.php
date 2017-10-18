<?php
App::uses('AppModel', 'Model');
class SourceSettings extends AppModel {
    
    public $name = 'SourceSettings';

    //$useTable = 'source_settings';

    public $validate = array(
	    'skupattern' => array(
	        'rule1' => array(
	            'rule' => 'alphaNumeric',
	            'message' => 'SKU Prefix does allow only alphabets and numbers',
	            'last' => false
	         ),
	        'rule2' => array(
	            'rule' => array('minLength', 3),
	            'message' => 'SKU Prefix does require length of 3 characters'
	        ),
	        'rule3' => array(
	            'rule' => array('maxLength', 3),
	            'message' => 'SKU Prefix does require length of 3 characters'
	        ),
	        'rule4' => array(
	        	'rule' => '/^[a-z]{1,}[a-z0-9]{2,}$/i',
	        	'message' => 'SKU Prefix is required, should be alpha-numeric only, first character should alphabet only, length should be 3 characters'
	        )
	    )
	);
    
}

//SKU is required, should be alpha-numeric only, first character should alphabet only, length should be 3 characters