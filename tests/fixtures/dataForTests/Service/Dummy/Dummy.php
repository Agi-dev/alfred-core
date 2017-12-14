<?php
/**
 * This file is part of the alfred-core project
 *
 * (c) AgiDev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Dummy extends \AlfredCore\Core\AbstractService
{
    protected $microtime;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->microtime = microtime();
    }
}