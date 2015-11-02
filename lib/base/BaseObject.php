<?php
/**
 * @link http://canis.io
 *
 * @copyright Copyright (c) 2015 Canis
 * @license http://canis.io/license/
 */

namespace canis\sensors\base;

use Yii;

abstract class BaseObject 
	extends \yii\base\Object
	implements BaseInterface
{
	public $invalidEntries = [];
	protected $_name;
	protected $_meta;
	protected $_model;
	protected $_parentObject;
	
	public function __sleep()
    {
        $keys = array_keys((array) $this);
        $bad = ["\0*\0_cache", "\0*\0_model"];
        foreach ($keys as $k => $key) {
            if (in_array($key, $bad)) {
                unset($keys[$k]);
            }
        }

        return $keys;
    }

	public function getPackage()
    {
    	$package = [];
    	$package['name'] = $this->getName();
    	$package['meta'] = $this->getMeta();
    	return $package;
    }

	public static function associateModels($parentModel, $childModel)
    {
    	return true;
    }

	public static function loadObject($config, $interfaceName)
    {
    	if (!isset($config['class']) || !class_exists($config['class'])) {
    		return false;
    	}
    	$reflection = new \ReflectionClass($config['class']);
    	if (!$reflection->implementsInterface($interfaceName)) {
    		return false;
    	}
    	try {
    		$object = Yii::createObject($config);
    	} catch (\Exception $e) {
    		$object = false;
    	}
    	return $object;
    }

	public function setName($name)
	{
		$this->_name = $name;
	}

	public function getName()
	{
		return $this->_name;
	}

    public function getModel()
    {
    	return $this->_model;
    }

    public function setModel($model)
    {
    	$this->_model = $model;
    	return $this;
    }

	public function setMeta($meta)
	{
		$this->_meta = $meta;
	}

	public function getMeta()
	{
		return $this->_meta;
	}

	public function setParentObject($parent)
	{
		$this->_parentObject = $parent;
	}

	public function getParentObject()
	{
		return $this->_parentObject;
	}
}