<?php
/**
 * @link http://canis.io
 *
 * @copyright Copyright (c) 2015 Canis
 * @license http://canis.io/license/
 */

namespace canis\sensors\providers;

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