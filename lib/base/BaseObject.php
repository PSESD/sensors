<?php
/**
 * @link https://www.psesd.org
 *
 * @copyright Copyright (c) 2016 Puget Sound ESD
 * @license https://raw.githubusercontent.com/PSESD/sensor/master/LICENSE/
 */

namespace psesd\sensors\base;

use Yii;

abstract class BaseObject 
	extends \yii\base\Component
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

    abstract public function getObjectTypeDescriptor();

    public function getInfo()
    {
        $info = [];
        if (($meta = $this->getMeta()) && !empty($meta)) {
            foreach ($meta as $key => $value) {
                if (substr($key, 0, 1) === '_') { continue; }
                $info[$key] = $value;
            }
        }
        return $info;
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
        if (!is_object($config)) {
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
                throw $e;
                $object = false;
            }
        } else {
            $object = $config;
            if (!is_a($object, $interfaceName)) {
                return false;
            }
        }
    	return $object;
    }

    public function simpleClone()
    {
        $cloneObject = $this->simpleProperties();;
        $cloneObject['class'] = get_class($this);
        return Yii::createObject($cloneObject);
    }

    public function simpleProperties()
    {
        return [
            'name' => $this->getName(),
            'meta' => $this->getMeta()
        ];
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

    public function defaultSensors()
    {
        return [];
    }

    public function onInstantiation($instance)
    {
        return true;
    }
}