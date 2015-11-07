<?php
/**
 * @link http://canis.io
 *
 * @copyright Copyright (c) 2015 Canis
 * @license http://canis.io/license/
 */

namespace canis\sensors\resources;

class IP extends Base
{
	public $ip;

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