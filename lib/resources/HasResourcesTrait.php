<?php
namespace canis\sensors\resources;

trait HasResourcesTrait {
	protected $_resources = [];
	public function setResources($resources)
	{
		$this->_resources = [];
		foreach ($resources as $resourceConfig) {
			if (($resource = static::loadObject($resourceConfig, ResourceInterface::class))) {
				$resource->parentObject = $this;
				$this->_resources[] = $resource;
			} else {
				if (!isset($this->invalidEntries['resources'])) {
					$this->invalidEntries['resources'] = [];
				}
				$this->invalidEntries['resources'][] = $resourceConfig;
			}
		}
		return $this;
	}

	public function getResources()
	{
		return $this->_resources;
	}
}