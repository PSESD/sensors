<?php
namespace canis\sensors\resourceReferences;

class HasResourceReferencesBehavior extends \canis\sensors\base\HasBaseBehavior
{
	protected $_resourceReferences = [];
	
	protected function getObjects()
	{
		return $this->getResourceReferences();
	}

	protected function getObjectType()
	{
		return 'resourceReference';
	}

	public function setResourceReferences($resourceReferences)
	{
		$this->_resourceReferences = [];
		foreach ($resourceReferences as $resourceReferenceConfig) {
			if (($resourceReference = static::loadObject($resourceReferenceConfig, ResourceReferenceInterface::class))) {
				$resourceReference->parentObject = $this->owner;
				$this->_resourceReferences[] = $resourceReference;
			} else {
				if (!isset($this->owner->invalidEntries['resourceReferences'])) {
					$this->owner->invalidEntries['resourceReferences'] = [];
				}
				$this->owner->invalidEntries['resourceReferences'][] = $resourceReferenceConfig;
			}
		}
		return $this;
	}


	public function getResourceReferences()
	{
		$resourceReferences = $this->_resourceReferences;
		foreach ($resourceReferences as $k => $resourceReference) {
			if ($resourceReference === false) {
				unset($resourceReferences[$k]);
			}
		}
		return $resourceReferences;
	}
}