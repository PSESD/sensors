<?php
namespace psesd\sensors\services;

class HasServicesBehavior extends \psesd\sensors\base\HasBaseBehavior
{
	protected $_services = [];
	
	protected function getObjects()
	{
		return $this->getServices();
	}

	protected function getObjectType()
	{
		return 'service';
	}

	public function setServices($services)
	{
		$this->_services = [];
		foreach ($services as $serviceConfig) {
			if (($service = static::loadObject($serviceConfig, ServiceInterface::class))) {
				$service->parentObject = $this->owner;
				$this->_services[] = $service;
			} else {
				if (!isset($this->owner->invalidEntries['services'])) {
					$this->owner->invalidEntries['services'] = [];
				}
				$this->owner->invalidEntries['services'][] = $serviceConfig;
			}
		}
		return $this;
	}

	public function getServices()
	{
		$services = $this->_services;
		foreach ($services as $k => $service) {
			if ($service === false) {
				unset($services[$k]);
			}
		}
		return $services;
	}
}