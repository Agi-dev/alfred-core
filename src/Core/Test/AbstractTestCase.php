<?php
/**
 * This file is part of the alfred-core project
 *
 * (c) AgiDev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AlfredCore\Core\Test;

use PHPUnit\Framework\TestCase;

/**
 * Class AbstractTestCase
 */
abstract class AbstractTestCase extends TestCase
{
    /**
     * Get fixtures path
     *
     * @return string
     */
    public function getFixturesPath()
    {
        return __DIR__ . '/../../../tests/fixtures';
    }

    /**
     * get data sets path
     *
     * @return string
     */
    public function getDataForTestsPath()
    {
        return $this->getFixturesPath() . '/dataForTests';
    }

    /**
     * get result sets path
     *
     * @return string
     */
    public function getResultSetsPath()
    {
        return $this->getFixturesPath() . '/resultSets';
    }

    /**
     * get sandbox path
     *
     * @return string
     */
    public function getSandBoxPath()
    {
        return $this->getFixturesPath() . '/sandBox';
    }

    /**
     * get protected value of an object
     *
     * @param mixed  $object
     * @param string $property
     *
     * @return mixed
     */
    public function getProtectedValue($object, $property)
    {
        return $this->readAttribute($object, $property);
    }
}