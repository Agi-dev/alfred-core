<?php
/**
 * This file is part of the alfred-core project
 *
 * (c) AgiDev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AlfredCore\Technical;

use AlfredCore\Core\AbstractService;
use AlfredCore\Interfaces\Core\ServiceInterface;
use AlfredCore\Interfaces\Technical\ContainerInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class Container
 */
class Container extends AbstractService implements ContainerInterface
{
    /**
     * @var array
     */
    protected $listDefinitions = ['services' => []];

    /**
     * list already instanced services
     *
     * @var array
     */
    protected $listInstances = [];

    /**
     * Add services definitions to Container
     *
     * @param string|array $definitions if string => it's a definitions file
     *
     * @return $this
     */
    public function addDefinitions($definitions)
    {
        if (false === is_array($definitions)) {
            if (false === is_file($definitions)) {
                throw new \RuntimeException('file not found ' . $definitions, 404);
            }

            /** @noinspection PhpIncludeInspection */
            $definitions = include $definitions;
        }

        if (true === empty($this->listDefinitions)) {
            $this->listDefinitions = $definitions;
            return $this;
        }

        // merge definitions
        $this->listDefinitions = array_replace_recursive($this->listDefinitions, $definitions);

        return $this;
    }

    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @throws NotFoundExceptionInterface  No entry was found for **this** identifier.
     * @throws ContainerExceptionInterface Error while retrieving the entry.
     *
     * @return mixed Entry.
     */
    public function get($id)
    {
        if (false === $this->has($id)) {
            throw new \RuntimeException('service id "' . $id . '" not exists');
        }

        if (false === array_key_exists($id, $this->listInstances)) {
            /** @var ServiceInterface $class */
            $class = $this->listDefinitions['services'][$id];
            $service = $class::factory();

            if ($service instanceof \ContainerConfigurableAwareInterface) {
                $config = (true === array_key_exists($id, $this->listDefinitions['configuration']) ? $this->listDefinitions['configuration'][$id]:[])
            }
            $this->listInstances[$id] = $service;
        }


        return $this->listInstances[$id];
    }

    /**
     * Returns true if the container can return an entry for the given identifier.
     * Returns false otherwise.
     *
     * `has($id)` returning true does not mean that `get($id)` will not throw an exception.
     * It does however mean that `get($id)` will not throw a `NotFoundExceptionInterface`.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return bool
     */
    public function has($id)
    {
        return array_key_exists($id, $this->listDefinitions['services']);
    }

    /**
     * get configuration for service
     *
     * @param $id
     *
     * @return array|null if not found
     *
    /
    protected function getConfigurationById($id)
    {
        if (true === isset($this->listDefinitions['configuration'][$id])) {
            return $this->listDefinitions['configuration'][$id];
        }

        return null;
    }


}