<?php
namespace canis\sensors\servers;

trait HasServersTrait
{
	protected $_servers = [];
	
	public function setServers($servers)
	{
		$this->_servers = [];
		foreach ($servers as $serverConfig) {
			if (($server = static::loadObject($serverConfig, ServerInterface::class))) {
				$server->parentObject = $this;
				$this->_servers[] = $server;
			} else {
				if (!isset($this->invalidEntries['servers'])) {
					$this->invalidEntries['servers'] = [];
				}
				$this->invalidEntries['servers'][] = $serverConfig;
			}
		}
		return $this;
	}

    protected function getDefaultServers()
    {
        $servers = [];
        foreach (static::defaultServers() as $serverConfig) {
            if (($server = static::loadObject($serverConfig, ServerInterface::class))) {
                $server->parentObject = $this;
                $servers[] = $server;
            }
        }
        return $servers;
    }


	public function getServers()
	{
		$servers = array_merge($this->getDefaultServers(), $this->_servers);
		foreach ($servers as $k => $server) {
			if ($server === false) {
				unset($servers[$k]);
			}
		}
		return $servers;
	}
}