<?php
/**
 * This file is part of the alfred-core project
 *
 * (c) AgiDev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AlfredCore\Interfaces\Technical;

/**
 * Interface ContainerInterface
 */
interface ContainerInterface extends \Psr\Container\ContainerInterface
{

    /**
     * Add services definitions to Container
     *
     * @param string|array $listDefinitions if string => it's a definitions file
     *
     * @return $this
     */
    public function addDefinitions($listDefinitions);
}