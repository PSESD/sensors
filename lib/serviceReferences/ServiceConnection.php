<?php
/**
 * @link https://www.psesd.org
 *
 * @copyright Copyright (c) 2016 Puget Sound ESD
 * @license https://raw.githubusercontent.com/PSESD/sensor/master/LICENSE/
 */

namespace psesd\sensors\serviceReferences;

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