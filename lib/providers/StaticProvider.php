<?php
/**
 * @link https://www.psesd.org
 *
 * @copyright Copyright (c) 2016 Puget Sound ESD
 * @license https://raw.githubusercontent.com/PSESD/sensor/master/LICENSE/
 */

namespace psesd\sensors\providers;

use Yii;
use psesd\sensors\sites\HasSitesBehavior;
use psesd\sensors\resources\HasResourcesBehavior;
use psesd\sensors\base\HasSensorsBehavior;
use psesd\sensors\remote\ProviderSensor;

abstract class Base 
	extends \psesd\sensors\base\BaseObject
	implements ProviderInterface
{
	use HasSitesBehavior;
	use HasResourcesBehavior;
	use HasSensorsBehavior;

	protected $_id;
	
	public function getObjectTypeDescriptor()
	{
		return 'Static Provider';
	}

	public function loadModels(callable $modelBuilder)
	{
		foreach ($this->resources as $resource) {
			if (!$resource->loadModels($modelBuilder)) {
				return false;
			}
		}
		foreach ($this->sites as $site) {
			if (!$site->loadModels($modelBuilder)) {
				return false;
			}
		}
		foreach ($this->sensors as $sensor) {
			if (!$sensor->loadModels($modelBuilder)) {
				return false;
			}
		}
		return true;
	}

	public function cleanModels(callable $modelBuilder)
	{
		
	}

	public function defaultSensors()
	{
		$sensors = parent::defaultSensors();
		$sensors['provider-sensor'] = [
			'class' => ProviderSensor::className()
		];
		return $sensors;
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
			$resource = new \psesd\sensors\resources\IP;
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
			if ($resource instanceof \psesd\sensors\resources\IP) {
				$resources[] = $resource;
			}
		}
		return $resources;
	}
}