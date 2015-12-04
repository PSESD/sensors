<?php
/**
 * @link http://canis.io
 *
 * @copyright Copyright (c) 2015 Canis
 * @license http://canis.io/license/
 */

namespace canis\sensors\servers;

class LinuxServer extends Server
{
	public function getObjectTypeDescriptor()
    {
        return 'Linux Server';
    }
}