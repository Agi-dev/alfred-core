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

use AlfredCore\Interfaces\Core\ServiceInterface;

require_once(__DIR__ . '/../../utils.php');

/**
 * Class AbstractServiceTestCase
 * @package AlfredCore\Core\Test
 */
class AbstractServiceTestCase extends AbstractTestCase
{
    /**
     * @var ServiceInterface
     */
    protected $currentService;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        parent::setUp();

        // instantiate service
        $class = str_replace('\\Tests', '', preg_replace('/UnitTest$/', '', get_class($this)));
        $this->currentService = $class::factory();
    }

    /**
     * @param $actual
     *
     * @return $this
     * @throws \Exception
     */
    public function assertEqualsResultSet($actual)
    {
        // get calling test method name
        $backtrace = debug_backtrace();
        $method = $backtrace[1]['function'];

        // get result set for this method
        $expected = $this->getResultSet($method);

        try {
            $this->assertEquals(json_decode($expected, true), $actual);
        } catch (\Exception $e) {
            $resultSetName = str_replace('.php', '_fix_DONOTCOMMIT.txt', $this->getResultFilename());
            $fileResultSet = $this->getResultSetsPath() . '/' . $resultSetName;
            $resultSet = "'$method' => '" . str_replace("'", "\\'", json_encode($actual)) . "',";

            s(
                array(
                    'file'               => $backtrace[0]['file'] . ' line ' . $backtrace[0]['line'],
                    'test'               => $method,
                    'expected'           => ($expected ? json_decode($expected, true) : 'to be setted'),
                    'actual'             => $actual,
                    'fixed into'         => $fileResultSet,
                    'result set to edit' => $this->getDataForTestsPath() . '/resultsSet/' . $this->getResultFilename(),
                )
            );
            file_put_contents($fileResultSet, $resultSet . PHP_EOL, FILE_APPEND);
            throw $e;
        };
        return $this;
    }

    /**
     * is triggered when invoking inaccessible methods in an object context.
     *
     * Use it for method s() and add autocompletion into test
     *
     * @param $name      string
     * @param $arguments array
     *
     * @return mixed
     * @link http://php.net/manual/en/language.oop5.overloading.php#language.oop5.overloading.methods
     */
    public function __call($name, $arguments)
    {
        if ('s' === $name) {
            return $this->currentService;
        }
    }

    /**
     * get result set
     *
     * @param string $key
     *
     * @return array|false false if result set not defined
     */
    protected function getResultSet($key)
    {
        $filename = $this->getResultSetsPath() . '/' . $this->getResultFilename();
        if (false === file_exists($filename)) {
            throw new \RuntimeException($this->getResultFilename() . ' is missing from result sets directory', 404 );
        }

        /** @noinspection PhpIncludeInspection */
        $rs = include($filename);

        if (true === isset($rs[$key])) {
            return $rs[$key];
        }
        return false;
    }

    /**
     * get result file name
     *
     * @return string
     */
    protected function getResultFilename()
    {
        $class = get_class($this->currentService);
        $f = explode('\\', $class);
        return $f[1] . '/' . $f[2] . 'RS.php';
    }
}