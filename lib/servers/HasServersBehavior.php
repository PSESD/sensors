<?php
namespace psesd\sensors\servers;

class HasServersBehavior extends \psesd\sensors\base\HasBaseBehavior
{
	protected $_servers = [];
	
	protected function getObjects()
	{
		return $this->getServers();
	}

	protected function getObjectType()
	{
		return 'server';
	}

	public function setServers($servers)
	{
		$this->_servers = [];
		foreach ($servers as $serverConfig) {
			if (($server = static::loadObject($serverConfig, ServerInterface::class))) {
				$server->parentObject = $this->owner;
				$this->_servers[] = $server;
			} else {
				if (!isset($this->owner->invalidEntries['servers'])) {
					$this->owner->invalidEntries['servers'] = [];
				}
				$this->owner->invalidEntries['servers'][] = $serverConfig;
			}
		}
		return $this;
	}

	public function getServers()
	{
		$servers = $this->_servers;
		foreach ($servers as $k => $server) {
			if ($server === false) {
				unset($servers[$k]);
			}
		}
		return $servers;
	}
}