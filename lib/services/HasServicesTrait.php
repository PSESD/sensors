<?php
namespace canis\sensors\services;

trait HasServicesTrait
{
	protected $_services = [];
	
	public function setServices($services)
	{
		$this->_services = [];
		foreach ($services as $serviceConfig) {
			if (($service = static::loadObject($serviceConfig, ServiceInterface::class))) {
				$service->parentObject = $this;
				$this->_services[] = $service;
			} else {
				if (!isset($this->invalidEntries['services'])) {
					$this->invalidEntries['services'] = [];
				}
				$this->invalidEntries['services'][] = $serviceConfig;
			}
		}
		return $this;
	}

    protected function getDefaultServices()
    {
        $services = [];
        foreach (static::defaultServices() as $serviceConfig) {
            if (($service = static::loadObject($serviceConfig, ServiceInterface::class))) {
                $service->parentObject = $this;
                $services[] = $service;
            }
        }
        return $services;
    }


	public function getServices()
	{
		$services = array_merge($this->getDefaultServices(), $this->_services);
		foreach ($services as $k => $service) {
			if ($service === false) {
				unset($services[$k]);
			}
		}
		return $services;
	}
}