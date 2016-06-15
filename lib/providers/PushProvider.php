<?php
/**
 * @link https://www.psesd.org
 *
 * @copyright Copyright (c) 2016 Puget Sound ESD
 * @license https://raw.githubusercontent.com/PSESD/sensor/master/LICENSE/
 */

namespace psesd\sensors\providers;

use Yii;
class PushProvider 
	extends Base
	implements PushProviderInterface
{
	public function getObjectTypeDescriptor()
	{
		return 'Push Provider';
	}
}