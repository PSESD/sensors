<?php
/**
 * @link http://canis.io
 *
 * @copyright Copyright (c) 2015 Canis
 * @license http://canis.io/license/
 */

namespace canis\sensors\services;

use Yii;
use canis\sensors\resources\HasResourcesTrait;
use canis\sensors\base\HasSensorsTrait;
use canis\sensors\remote\servicesensor;

abstract class Base 
	extends \canis\sensors\base\BaseObject
	implements ServiceInterface
{
	use HasResourcesTrait;
	use HasSensorsTrait;

	protected $_id;
	protected $_server;

	
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