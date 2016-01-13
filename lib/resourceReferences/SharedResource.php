<?php
/**
 * @link https://www.psesd.org
 *
 * @copyright Copyright (c) 2016 Puget Sound ESD
 * @license https://raw.githubusercontent.com/PSESD/sensor/master/LICENSE/
 */

namespace psesd\sensors\resourceReferences;

use Yii;

class SharedResource 
	extends Base
{
	public function getType()
	{
		return 'shared';
	}
}