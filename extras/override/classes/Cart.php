<?php
class Cart extends CartCore{
	public $combinaciones;

	public function __construct($id = null, $id_lang = null)
    {
    	self::$definition['fields']['combinaciones'] = array('type' => self::TYPE_STRING, 'validate' => 'isString');
    	parent::__construct($id, $id_lang);
    }
}