<?php
/**
 * @link http://canis.io
 *
 * @copyright Copyright (c) 2015 Canis
 * @license http://canis.io/license/
 */

namespace canis\sensors\services;

use Yii;
use canis\sensors\resources\HasResourcesBehavior;
use canis\sensors\resourceReferences\HasResourceReferencesBehavior;
use canis\sensors\base\HasSensorsBehavior;
use canis\sensors\remote\servicesensor;

abstract class Base 
	extends \canis\sensors\base\BaseObject
	implements ServiceInterface
{
	protected $_id;
	protected $_server;

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
            'server' => $this->getServer(),
            'id' => $this->getId()
        ]);
    }

	public function setServer($server)
	{
		$this->_server = $server;
	}


	public function getServer()
	{
		return $this->_server;
	}


	public function setId($id)
	{
		$this->_id = $id;
	}

	public function getId()
	{
		if (!isset($this->_id)) {
			return $this->defaultId;
		}
		return $this->_id;
	}

	public function getName()
	{
		if (!isset($this->_name)) {
			return $this->defaultName;
		}
		return $this->_name;
	}

	abstract public function getDefaultName();

	abstract public function getDefaultId();

	abstract public function getType();

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