<?php
/**
 * This file is part of the alfred-core project
 *
 * (c) AgiDev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace AlfredCore\Core;

use AlfredCore\Interfaces\Core\ServiceInterface;


/**
 * Class AbstractService
 * @package AlfredCore\Core
 */
class AbstractService implements ServiceInterface
{
    /**
     * Returns a new instance
     *
     * @return ServiceInterface
     */
    public static function factory(): ServiceInterface
    {
        return new static();
    }
}