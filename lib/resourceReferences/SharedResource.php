<?php
/**
 * @link http://canis.io
 *
 * @copyright Copyright (c) 2015 Canis
 * @license http://canis.io/license/
 */

namespace canis\sensors\resourceReferences;

use Yii;

class SharedResource 
	extends Base
{
	public function getType()
	{
		return 'shared';
	}
}