<?php
namespace canis\sensors\serviceReferences;

trait HasServiceReferencesTrait
{
	protected $_serviceReferences = [];
	
	public function setServiceReferences($serviceReferences)
	{
		$this->_serviceReferences = [];
		foreach ($serviceReferences as $serviceReferenceConfig) {
			if (($serviceReference = static::loadObject($serviceReferenceConfig, ServiceReferenceInterface::class))) {
				$serviceReference->parentObject = $this;
				$this->_serviceReferences[] = $serviceReference;
			} else {
				if (!isset($this->invalidEntries['serviceReferences'])) {
					$this->invalidEntries['serviceReferences'] = [];
				}
				$this->invalidEntries['serviceReferences'][] = $serviceReferenceConfig;
			}
		}
		return $this;
	}

    protected function getDefaultServiceReferences()
    {
        $serviceReferences = [];
        foreach (static::defaultServiceReferences() as $serviceReferenceConfig) {
            if (($serviceReference = static::loadObject($serviceReferenceConfig, ServiceReferenceInterface::class))) {
                $serviceReference->parentObject = $this;
                $serviceReferences[] = $serviceReference;
            }
        }
        return $serviceReferences;
    }


	public function getServiceReferences()
	{
		$serviceReferences = array_merge($this->getDefaultServiceReferences(), $this->_serviceReferences);
		foreach ($serviceReferences as $k => $serviceReference) {
			if ($serviceReference === false) {
				unset($serviceReferences[$k]);
			}
		}
		return $serviceReferences;
	}
}