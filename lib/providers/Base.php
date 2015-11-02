<?php
/**
 * @link http://canis.io
 *
 * @copyright Copyright (c) 2015 Canis
 * @license http://canis.io/license/
 */

namespace canis\sensors\providers;

use canis\sensors\sites\HasSitesTrait;
use canis\sensors\assets\HasAssetsTrait;
use canis\sensors\base\HasSensorsTrait;

abstract class Base 
	extends \canis\sensors\base\BaseObject
	implements ProviderInterface
{
	use HasSitesTrait;
	use HasAssetsTrait;
	use HasSensorsTrait;

	protected $_id;

	public function loadModels(callable $modelBuilder)
	{
		foreach ($this->assets as $asset) {
			if (!$asset->loadModels($modelBuilder)) {
				return false;
			}
		}
		foreach ($this->sites as $site) {
			if (!$site->loadModels($modelBuilder)) {
				return false;
			}
		}
		foreach ($this->sensors as $sensor) {
			if (!$sensor->loadModels($modelBuilder)) {
				return false;
			}
		}
		return true;
	}

	public function cleanModels(callable $modelBuilder)
	{
		
	}

	public function setId($id)
	{
		$this->_id = $id;
	}

	public function getId()
	{
		return $this->_id;
	}

	public function getIpAsset($ip, $create = true)
	{
		$assets = $this->ipAssets;
		foreach ($assets as $ipAsset) {
			if ($ipAsset->ip === $ip) {
				return $ipAsset;
			}
		}
		if ($create) {
			$asset = new \canis\sensors\assets\IP;
			$asset->ip = $ip;
			$asset->parentObject = $this;
			$this->_assets[] = $asset;
			return $asset;
		}
		return false;
	}

	public function getIpAssets()
	{
		$assets = [];
		foreach ($this->assets as $asset) {
			if ($asset instanceof \canis\sensors\assets\IP) {
				$assets[] = $asset;
			}
		}
		return $assets;
	}
}