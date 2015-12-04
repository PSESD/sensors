<?php
/**
 * @link http://canis.io
 *
 * @copyright Copyright (c) 2015 Canis
 * @license http://canis.io/license/
 */

namespace canis\sensors\resourceReferences;

use Yii;
use canis\sensors\resources\HasResourcesBehavior;
use canis\sensors\base\HasSensorsBehavior;
use canis\sensors\remote\resourcesensor;

abstract class Base 
	extends \canis\sensors\base\BaseObject
	implements ResourceReferenceInterface
{
	protected $_object;
	protected $_objectType;
	protected $_resource;

	abstract public function getType();

	public function getObjectTypeDescriptor()
	{
		return 'Resource Reference';
	}

	public function behaviors()
	{
		return array_merge(parent::behaviors(), [
		]);
	}

	public function simpleProperties()
    {
        return array_merge(parent::simpleProperties(), [
            'object' => $this->getObject(),
            'resource' => $this->getResource()
        ]);
    }

	public function getId()
	{
		return $this->object .'.' . $this->resource;
	}
	
	public function setObject($object)
	{
		$this->_object = $object;
	}


	public function getObject()
	{
		return $this->_object;
	}

	public function setObjectType($objectType)
	{
		$this->_objectType = $objectType;
	}


	public function getObjectType()
	{
		return $this->_objectType;
	}

	public function getResource()
	{
		return $this->_resource;
	}

	public function setResource($resource)
	{
		$this->_resource = $resource;
	}

	public function discoverObject($providerInstance, $sameProvider = false)
	{
		if (empty($this->object) || empty($this->objectType)) {
			return false;
		}
		$where = [];
		if ($sameProvider) {
			$where['provider_id'] = $providerInstance->model->primaryKey;
		}
		return $providerInstance->discoverObject($this->objectType, $this->object, $where);
	}

	public function discoverObjectId($providerInstance, $sameProvider = false)
	{
		if (!($object = $this->discoverObject($providerInstance, $sameProvider))) {
			return null;
		}
		return $object->primaryKey;
	}

	public function discoverResource($providerInstance, $sameProvider = false)
	{
		if (empty($this->resource)) {
			return false;
		}
		$where = [];
		if (!($objectId = $this->discoverObjectId($providerInstance, $sameProvider))) {
			return false;
		}
		$where['object_id'] = $objectId;
		if ($sameProvider) {
			$where['provider_id'] = $providerInstance->model->primaryKey;
		}

		return $providerInstance->discoverObject('resource', $this->resource, $where);
	}

	public function discoverResourceId($providerInstance, $sameProvider = false)
	{
		if (!($resource = $this->discoverResource($providerInstance, $sameProvider))) {
			return null;
		}
		return $resource->primaryKey;
	}

	public function getIpResources()
	{
		$resources = [];
		foreach ($this->resources as $resource) {
			if ($resource instanceof \canis\sensors\resources\IP) {
				$resources[] = $resource;
			}
		}
		return $resources;
	}
}