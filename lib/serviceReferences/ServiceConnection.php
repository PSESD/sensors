<?php
/**
 * @link http://canis.io
 *
 * @copyright Copyright (c) 2015 Canis
 * @license http://canis.io/license/
 */

namespace canis\sensors\serviceReferences;

use Yii;
class ServiceConnection 
	extends Base
{
	public function getType()
	{
		return 'connection';
	}

	public function getObjectTypeDescriptor()
    {
        return 'Service Connection';
    }
}