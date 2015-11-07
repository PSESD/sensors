<?php
namespace canis\sensors\sites;

class HasSitesBehavior extends \canis\sensors\base\HasBaseBehavior
{
	protected $_sites = [];
	
	protected function getObjects()
	{
		return $this->getSitesBehavior();
	}

	protected function getObjectType()
	{
		return 'site';
	}

	public function setSites($sites)
	{
		$this->_sites = [];
		foreach ($sites as $siteConfig) {
			if (($site = static::loadObject($siteConfig, SiteInterface::class))) {
				$site->parentObject = $this->owner;
				$site->ips;
				$this->_sites[] = $site;
			} else {
				if (!isset($this->owner->invalidEntries['sites'])) {
					$this->owner->invalidEntries['sites'] = [];
				}
				$this->owner->invalidEntries['sites'][] = $siteConfig;
			}
		}
		return $this;
	}

	public function getSites()
	{
		return $this->_sites;
	}
}