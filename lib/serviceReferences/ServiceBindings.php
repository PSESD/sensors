<?php
/**
 * @link http://canis.io
 *
 * @copyright Copyright (c) 2015 Canis
 * @license http://canis.io/license/
 */

namespace canis\sensors\serviceReferences;

use Yii;

class ServiceBindings 
	extends Base
{
	public $bindings;

	public function getObjectTypeDescriptor()
    {
        return 'Service Binding';
    }

	public function getType()
	{
		return 'binding';
	}
	
	public function simpleProperties()
    {
        return array_merge(parent::simpleProperties(), [
            'bindings' => $this->bindings
        ]);
    }

}