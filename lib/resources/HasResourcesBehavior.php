<?php
namespace psesd\sensors\resources;

class HasResourcesBehavior extends \psesd\sensors\base\HasBaseBehavior
{
	protected $_resources = [];

	protected function getObjects()
	{
		return $this->getResources();
	}

	protected function getObjectType()
	{
		return 'resource';
	}

	public function setResources($resources)
	{
		$this->_resources = [];
		foreach ($resources as $resourceConfig) {
			if (($resource = static::loadObject($resourceConfig, ResourceInterface::class))) {
				$resource->parentObject = $this->owner;
				$this->_resources[] = $resource;
			} else {
				if (!isset($this->owner->invalidEntries['resources'])) {
					$this->owner->invalidEntries['resources'] = [];
				}
				$this->owner->invalidEntries['resources'][] = $resourceConfig;
			}
		}
		return $this;
	}

	public function getResources()
	{
		return $this->_resources;
	}
}