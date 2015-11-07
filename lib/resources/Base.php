<?php
/**
 * @link http://canis.io
 *
 * @copyright Copyright (c) 2015 Canis
 * @license http://canis.io/license/
 */

namespace canis\sensors\resources;


abstract class Base 
	extends \canis\sensors\base\BaseObject
	implements ResourceInterface
{
	abstract public function getType();
	

	public function simpleProperties()
    {
        return array_merge(parent::simpleProperties(), [
            'id' => $this->getId()
        ]);
    }
    
	public function getPackage()
    {
    	$package = parent::getPackage();
    	$package['id'] = $this->getId();
    	return $package;
    }
}