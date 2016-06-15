<?php
/**
 * @link https://www.psesd.org
 *
 * @copyright Copyright (c) 2016 Puget Sound ESD
 * @license https://raw.githubusercontent.com/PSESD/sensor/master/LICENSE/
 */

namespace psesd\sensors\sites;

use Yii;
use psesd\sensors\base\HasSensorsBehavior;
use psesd\sensors\services\HasServicesBehavior;
use psesd\sensors\serviceReferences\HasServiceReferencesBehavior;
use psesd\sensors\resourceReferences\HasResourceReferencesBehavior;
use psesd\sensors\resources\HasResourcesBehavior;

abstract class Base 
	extends \psesd\sensors\base\BaseObject
	implements SiteInterface
{
	protected $_ips = [];
	protected $_url;
	protected $_id;
	protected $_testUrl;
	protected $_testLookFor = false;
	
	public function getObjectTypeDescriptor()
    {
        return 'Site';
    }

	public function behaviors()
	{
		return array_merge(parent::behaviors(), [
			'HasSensors' => ['class' => HasSensorsBehavior::className()],
			'HasServices' => ['class' => HasServicesBehavior::className()],
			'HasServiceReferences' => ['class' => HasServiceReferencesBehavior::className()],
			'HasResourceReferences' => ['class' => HasResourceReferencesBehavior::className()],
			'HasResources' => ['class' => HasResourcesBehavior::className()],
		]);
	}

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
    public function simpleProperties()
    {
        return array_merge(parent::simpleProperties(), [
            'id' => $this->getId(),
            'url' => $this->getUrl(),
            'testUrl' => $this->getTestUrl(),
            'testLookFor' => $this->getTestLookFor()
        ]);
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
				if (($ipResource = $this->parentObject->getIpResource($ip))) {
					$this->_ips[$key] = $ipResource;
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

	public function setUrl($url)
	{
		$this->_url = $url;
		return $this;
	}

	public function getUrl()
	{
		return $this->_url;
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
    	return $package;
    }

	public function defaultSensors()
	{
		$sensors = parent::defaultSensors();
		return $sensors;
	}

}