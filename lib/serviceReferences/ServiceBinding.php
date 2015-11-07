<?php
/**
 * @link http://canis.io
 *
 * @copyright Copyright (c) 2015 Canis
 * @license http://canis.io/license/
 */

namespace canis\sensors\serviceReferences;

use Yii;

class ServiceBinding 
	extends Base
{
	public $binding;

	public function getType()
	{
		return 'binding';
	}
	
	public function simpleProperties()
    {
        return array_merge(parent::simpleProperties(), [
            'binding' => $this->binding
        ]);
    }

}