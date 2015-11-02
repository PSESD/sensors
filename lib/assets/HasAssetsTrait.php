<?php
namespace canis\sensors\assets;

trait HasAssetsTrait {
	protected $_assets = [];
	public function setAssets($assets)
	{
		$this->_assets = [];
		foreach ($assets as $assetConfig) {
			if (($asset = static::loadObject($assetConfig, AssetInterface::class))) {
				$asset->parentObject = $this;
				$this->_assets[] = $asset;
			} else {
				if (!isset($this->invalidEntries['assets'])) {
					$this->invalidEntries['assets'] = [];
				}
				$this->invalidEntries['assets'][] = $assetConfig;
			}
		}
		return $this;
	}

	public function getAssets()
	{
		return $this->_assets;
	}
}