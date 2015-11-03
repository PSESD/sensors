<?php
/**
 * @link http://canis.io
 *
 * @copyright Copyright (c) 2015 Canis
 * @license http://canis.io/license/
 */

namespace canis\sensors\sites;

use Yii;
use canis\sensors\base\HasSensorsTrait;

abstract class Base 
	extends \canis\sensors\base\BaseObject
	implements SiteInterface
{
	use HasSensorsTrait;

	protected $_ips = [];
	protected $_hostnames = [];
	protected $_services = [];
	protected $_id;
	protected $_testUrl;
	protected $_testLookFor = false;
	
	public function __sleep()
    {
        $keys = parent::__sleep();
        foreach ($this->_ips as $key => $ip) {
        	if (is_object($ip)) {
        		$this->_ips[$key] = $ip->ip;
        	}
        }

        return $keys;
    }

	public function loadModels(callable $modelBuilder)
	{
		if ($this->getModel() === null) {
			$this->_model = $modelBuilder($this);
		}
		if (!$this->_model) {
			return false;
		}
		foreach ($this->sensors as $sensor) {
			if (!$sensor->loadModels($modelBuilder)) {
				return false;
			}
		}
		foreach ($this->getIps() as $ip) {
			if ($ip->getModel() !== null && !static::associateModels($this->getModel(), $ip->getModel())) {
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

	public function setIps(array $ips)
	{
		$this->_ips = array_values($ips);
		return $this;
	}

	public function setIp(string $ip)
	{
		$this->ips = [$ip];
		return $this;
	}

	public function getIps()
	{
		foreach ($this->_ips as $key => $ip) {
			if (!is_object($ip) && $this->parentObject !== null) {
				if (($ipAsset = $this->parentObject->getIpAsset($ip))) {
					$this->_ips[$key] = $ipAsset;
				} else {
					unset($this->_ips[$key]);
				}
			}
		}
		return $this->_ips;
	}

	public function getIp()
	{
		if (!empty($this->_ips)) {
			return $this->_ips[0];
		}
		return null;
	}
	public function setHostnames(array $hostnames)
	{
		$this->_hostnames = array_values($hostnames);
		return $this;
	}

	public function setHostname(string $hostname)
	{
		$this->_hostnames = [$hostname];
		return $this;
	}

	public function getHostnames()
	{
		return $this->_hostnames;
	}

	public function getHostname()
	{
		if (!empty($this->_hostnames)) {
			return $this->_hostnames[0];
		}
		return null;
	}

	public function getService()
	{
		if (in_array('https', $this->services)) {
			return 'https';
		}
		return $this->services[0];
	}

	public function getServices()
	{
		if (empty($this->_services)) {
			return ['http'];
		}
		return $this->_services;
	}

	public function setServices(array $services)
	{
		$this->_services = array_values($services);
		return $this;
	}

	public function getUrl()
	{
		if (($protocol = $this->service) && ($hostname = $this->hostname)) {
			return $protocol .'://' . $hostname;
		}
		return false;
	}

	public function getTestUrl()
	{
		if (isset($this->_testUrl)) {
			return $this->_testUrl;
		}
		return $this->getUrl();
	}

	public function setTestUrl($url)
	{
		$this->_testUrl = $url;
		return $this;
	}

	public function getTestLookFor()
	{
		return $this->_testLookFor;
	}

	public function setTestLookFor($look)
	{
		$this->_testLookFor = $look;
		return $this;
	}

	public function getPackage()
    {
    	$package = parent::getPackage();
    	$package['id'] = $this->getId();
    	$package['url'] = $this->getUrl();
    	$package['hostnames'] = $this->getHostnames();
    	return $package;
    }

	protected function defaultSensors()
	{
		$sensors = parent::defaultSensors();

		return $sensors;
	}
}