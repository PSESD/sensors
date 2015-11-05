<?php
/**
 * @link http://canis.io
 *
 * @copyright Copyright (c) 2015 Canis
 * @license http://canis.io/license/
 */

namespace canis\sensors\servers;

use Yii;
use canis\sensors\resources\HasResourcesTrait;
use canis\sensors\base\HasSensorsTrait;
use canis\sensors\services\HasServicesTrait;

abstract class Base 
	extends \canis\sensors\base\BaseObject
	implements ServerInterface
{
	use HasResourcesTrait;
	use HasSensorsTrait;
	use HasServicesTrait;

	protected $_id;

	public function loadModels(callable $modelBuilder)
	{
		foreach ($this->resources as $resource) {
			if (!$resource->loadModels($modelBuilder)) {
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