<?php
/**
 * @link http://canis.io
 *
 * @copyright Copyright (c) 2015 Canis
 * @license http://canis.io/license/
 */

namespace canis\sensors\resources;

class Database extends Base
{
	public $dbName;

	public function getObjectTypeDescriptor()
    {
        return 'Database';
    }

	public function simpleProperties()
    {
    	$properties = parent::simpleProperties();
    	unset($properties['id']);
        return array_merge($properties, [
            'dbName' => $this->dbName
        ]);
    }

	public function getId()
	{
		return 'database.'.$this->dbName;
	}

	public function getName()
	{
		return $this->dbName;
	}

	public function getType()
	{
		return 'database';
	}

	public function getPackage()
    {
    	$package = parent::getPackage();
    	$package['id'] = $this->getId();
    	$package['dbName'] = $this->dbName;
    	return $package;
    }
}