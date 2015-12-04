<?php
/**
 * @link http://canis.io
 *
 * @copyright Copyright (c) 2015 Canis
 * @license http://canis.io/license/
 */

namespace canis\sensors\servers;

use Yii;
use canis\sensors\resources\HasResourcesBehavior;
use canis\sensors\resourceReferences\HasResourceReferencesBehavior;
use canis\sensors\base\HasSensorsBehavior;
use canis\sensors\services\HasServicesBehavior;

abstract class Base 
	extends \canis\sensors\base\BaseObject
	implements ServerInterface
{
	protected $_id;

	public function getObjectTypeDescriptor()
    {
        return 'Server';
    }

	public function behaviors()
	{
		return array_merge(parent::behaviors(), [
			'HasSensors' => ['class' => HasSensorsBehavior::className()],
			'HasServices' => ['class' => HasServicesBehavior::className()],
			'HasResourceReferences' => ['class' => HasResourceReferencesBehavior::className()],
			'HasResources' => ['class' => HasResourcesBehavior::className()],
		]);
	}

	public function simpleProperties()
    {
        return array_merge(parent::simpleProperties(), [
            'id' => $this->getId()
        ]);
    }

	public function setId($id)
	{
		$this->_id = $id;
	}

	public function getId()
	{
		return $this->_id;
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