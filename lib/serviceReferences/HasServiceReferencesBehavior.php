<?php
namespace psesd\sensors\serviceReferences;

class HasServiceReferencesBehavior extends \psesd\sensors\base\HasBaseBehavior
{
	protected $_serviceReferences = [];
	
	protected function getObjects()
	{
		return $this->getServiceReferences();
	}
	
	protected function getObjectType()
	{
		return 'serviceReference';
	}

	public function setServiceReferences($serviceReferences)
	{
		$this->_serviceReferences = [];
		foreach ($serviceReferences as $serviceReferenceConfig) {
			if (($serviceReference = static::loadObject($serviceReferenceConfig, ServiceReferenceInterface::class))) {
				$serviceReference->parentObject = $this->owner;
				$this->_serviceReferences[] = $serviceReference;
			} else {
				if (!isset($this->owner->invalidEntries['serviceReferences'])) {
					$this->owner->invalidEntries['serviceReferences'] = [];
				}
				$this->owner->invalidEntries['serviceReferences'][] = $serviceReferenceConfig;
			}
		}
		return $this;
	}


	public function getServiceReferences()
	{
		$serviceReferences = $this->_serviceReferences;
		foreach ($serviceReferences as $k => $serviceReference) {
			if ($serviceReference === false) {
				unset($serviceReferences[$k]);
			}
		}
		return $serviceReferences;
	}
}