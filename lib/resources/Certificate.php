<?php
/**
 * @link http://canis.io
 *
 * @copyright Copyright (c) 2015 Canis
 * @license http://canis.io/license/
 */

namespace canis\sensors\resources;

class Certificate extends Base
{
	protected $_id;
	public $startDate;
	public $expirationDate;

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