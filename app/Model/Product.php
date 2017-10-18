<?php
App::uses('AppModel', 'Model');
class Product extends AppModel {
    
    public $name = 'Product';
    
    //public $hasMany = array('Image');
    
//    public $hasMany = array(
//        'Image' => array(
//            'conditions' => array('Image.status like' => 'Active'),
//            'order' => 'Image.id asc',
//            //'limit'=>1
//        )
//    );
    
}