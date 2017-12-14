<?php
/**
 * This file is part of the alfred-core project
 *
 * (c) AgiDev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
interface ContainerConfigurableAwareInterface
{
    /**
     * set config to service
     *
     * @param $config
     *
     * @return $this
     */
    public function setConfig($config);
}