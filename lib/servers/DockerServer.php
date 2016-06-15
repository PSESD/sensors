<?php
/**
 * @link https://www.psesd.org
 *
 * @copyright Copyright (c) 2016 Puget Sound ESD
 * @license https://raw.githubusercontent.com/PSESD/sensor/master/LICENSE/
 */

namespace psesd\sensors\servers;

class DockerServer extends LinuxServer
{
	public function getObjectTypeDescriptor()
    {
        return 'Docker Server';
    }
}