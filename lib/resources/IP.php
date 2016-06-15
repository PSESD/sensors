<?php
/**
 * @link https://www.psesd.org
 *
 * @copyright Copyright (c) 2016 Puget Sound ESD
 * @license https://raw.githubusercontent.com/PSESD/sensor/master/LICENSE/
 */

namespace psesd\sensors\resources;

class IP extends Base
{
	public $ip;

	public function getObjectTypeDescriptor()
    {
        return 'IP Address';
    }

	public function simpleProperties()
    {
    	$properties = parent::simpleProperties();
    	unset($properties['id']);
        return array_merge($properties, [
            'ip' => $this->ip
        ]);
    }

	public function getId()
	{
		return 'ip.'.$this->ip;
	}

	public function getName()
	{
		return $this->ip;
	}

	public function getType()
	{
		return 'ip';
	}

	public function getPackage()
    {
    	$package = parent::getPackage();
    	$package['id'] = $this->getId();
    	$package['ip'] = $this->ip;
    	return $package;
    }
}