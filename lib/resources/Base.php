<?php
/**
 * @link https://www.psesd.org
 *
 * @copyright Copyright (c) 2016 Puget Sound ESD
 * @license https://raw.githubusercontent.com/PSESD/sensor/master/LICENSE/
 */

namespace psesd\sensors\resources;

use psesd\sensors\base\HasSensorsBehavior;

abstract class Base 
	extends \psesd\sensors\base\BaseObject
	implements ResourceInterface
{
	abstract public function getType();
	
    public function getObjectTypeDescriptor()
    {
        return 'Resource';
    }

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'HasSensors' => ['class' => HasSensorsBehavior::className()],
        ]);
    }

	public function simpleProperties()
    {
        return array_merge(parent::simpleProperties(), [
            'id' => $this->getId()
        ]);
    }
    
	public function getPackage()
    {
    	$package = parent::getPackage();
    	$package['id'] = $this->getId();
    	return $package;
    }
}