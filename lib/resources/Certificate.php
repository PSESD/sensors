<?php
/**
 * @link https://www.psesd.org
 *
 * @copyright Copyright (c) 2016 Puget Sound ESD
 * @license https://raw.githubusercontent.com/PSESD/sensor/master/LICENSE/
 */

namespace psesd\sensors\resources;

class Certificate extends Base
{
	protected $_id;
	public $startDate;
	public $expirationDate;

	public function getObjectTypeDescriptor()
    {
        return 'SSL Certificate';
    }

	public function simpleProperties()
    {
        return array_merge(parent::simpleProperties(), [
            'id' => $this->getId(),
            'expirationDate' => $this->expirationDate,
            'startDate' => $this->startDate 
        ]);
    }

	public function setId($id)
	{
		$this->_id = $id;
		return $this;
	}

	public function getId()
	{
		return $this->_id;
	}

	public function getType()
	{
		return 'certificate';
	}

	public function getPackage()
    {
    	$package = parent::getPackage();
    	$package['id'] = $this->getId();
    	$package['startDate'] = $this->startDate;
    	$package['expirationDate'] = $this->expirationDate;
    	return $package;
    }
}