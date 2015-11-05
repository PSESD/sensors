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
	public function loadModels(callable $modelBuilder)
	{
		if ($this->getModel() === null) {
			$this->_model = $modelBuilder($this);
		}
		if (!$this->_model) {
			return false;
		}
		return true;
	}

	public function cleanModels(callable $modelBuilder)
	{
		
	}
	public function getPackage()
    {
    	$package = parent::getPackage();
    	$package['id'] = $this->getId();
    	return $package;
    }
}