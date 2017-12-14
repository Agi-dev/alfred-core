<?php
/**
 * This file is part of the alfred-core project
 *
 * (c) AgiDev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class DummyConfig extends \AlfredCore\Core\AbstractService
{
    protected $microtime;

    protected $config;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->microtime = microtime();
    }
}