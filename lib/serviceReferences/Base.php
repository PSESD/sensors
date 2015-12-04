<?php
/**
 * @link http://canis.io
 *
 * @copyright Copyright (c) 2015 Canis
 * @license http://canis.io/license/
 */

namespace canis\sensors\serviceReferences;

use Yii;
use canis\sensors\resources\HasResourcesBehavior;
use canis\sensors\resourceReferences\HasResourceReferencesBehavior;
use canis\sensors\base\HasSensorsBehavior;
use canis\sensors\remote\servicesensor;

abstract class Base 
	extends \canis\sensors\base\BaseObject
	implements ServiceReferenceInterface
{
	protected $_object;
	protected $_objectType;
	protected $_service;

	abstract public function getType();

	public function getObjectTypeDescriptor()
    {
        return 'Service Reference';
    }
    
	public function behaviors()
	{
		return array_merge(parent::behaviors(), [
			'HasSensors' => ['class' => HasSensorsBehavior::className()],
			'HasResourceReferences' => ['class' => HasResourceReferencesBehavior::className()],
			'HasResources' => ['class' => HasResourcesBehavior::className()],
		]);
	}

	public function simpleProperties()
    {
        return array_merge(parent::simpleProperties(), [
            'object' => $this->getObject(),
            'service' => $this->getService()
        ]);
    }

	public function getId()
	{
		return $this->object .'.' . $this->service;
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

	public function getService()
	{
		return $this->_service;
	}

	public function setService($service)
	{
		$this->_service = $service;
	}

	public function getIpResource($ip, $create = true)
	{
		$resources = $this->ipResources;
		foreach ($resources as $ipResource) {
			if ($ipResource->ip === $ip) {
				return $ipResource;
			}
		}
		if ($create) {
			$resource = new \canis\sensors\resources\IP;
			$resource->ip = $ip;
			$resource->parentObject = $this;
			$this->_resources[] = $resource;
			return $resource;
		}
		return false;
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

	public function discoverService($providerInstance, $sameProvider = false)
	{
		if (empty($this->service)) {
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
		return $providerInstance->discoverObject('service', $this->service, $where);
	}

	public function discoverServiceId($providerInstance, $sameProvider = false)
	{
		if (!($service = $this->discoverService($providerInstance, $sameProvider))) {
			return null;
		}
		return $service->primaryKey;
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