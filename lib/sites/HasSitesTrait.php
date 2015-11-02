<?php
namespace canis\sensors\sites;

trait HasSitesTrait
{
	protected $_sites = [];

	public function setSites($sites)
	{
		$this->_sites = [];
		foreach ($sites as $siteConfig) {
			if (($site = static::loadObject($siteConfig, SiteInterface::class))) {
				$site->parentObject = $this;
				$site->ips;
				$this->_sites[] = $site;
			} else {
				if (!isset($this->invalidEntries['sites'])) {
					$this->invalidEntries['sites'] = [];
				}
				$this->invalidEntries['sites'][] = $siteConfig;
			}
		}
		return $this;
	}

	public function getSites()
	{
		return $this->_sites;
	}
}