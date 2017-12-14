<?php
/**
 * This file is part of the alfred-core project
 *
 * (c) AgiDev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AlfredCore\Tests\Technical;

use AlfredCore\Core\Test\AbstractServiceTestCase;
use AlfredCore\Technical\Container;

/**
 * Class ContainerUnitTest
 * @package AlfredCore\Tests\Technical
 *
 * @method Container s()
 */
class ContainerUnitTest extends AbstractServiceTestCase
{
    /**
     * init container for testing purpose
     */
    protected function initContainerForTest()
    {
        $file = $this->getDataForTestsPath() . '/Container/definitions.php';
        $this->s()->addDefinitions($file);
    }

    /**
     * addDefinitions
     */
    public function testAddDefinitionsWithArrayReturnSelf()
    {
        $this->s()->addDefinitions(['services' => ['some definitions']]);
        $this->assertEquals(['services' => ['some definitions']],
            $this->getProtectedValue($this->s(), 'listDefinitions'));
    }

    public function testAddDefinitionsWithAlreadyExistingDefinitionsReturnSelf()
    {
        $def1 = ['toto' => [1, 2, 3], 'ata' => ['oto' => array('itt', 'utt')], 'stay' => 'stay'];
        $def2 = [
            'toto' => [2, 3],
            'ata'  => ['oto' => array('itt', 'att', 'ztt'), 'ete' => array('toto', 'titi')],
            'stay' => 'stay'
        ];
        $this->s()->addDefinitions(['services' => $def1]);
        $this->s()->addDefinitions(['services' => $def2]);
        $actual = $this->getProtectedValue($this->s(), 'listDefinitions');
        $this->assertEqualsResultSet($actual);
    }

    public function testAddDefinitionsWithFileNotExistThrowRuntimeException()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('file not found fileNotExisting');
        $this->s()->addDefinitions('fileNotExistings');
    }

    public function testAddDefinitionsWithFileReturnSelf()
    {
        $this->s()->addDefinitions($this->getDataForTestsPath() . '/Container/simple_definitions.php');
        $this->assertEquals(['services' => 'some definitions from a file'],
            $this->getProtectedValue($this->s(), 'listDefinitions'));
    }

    /**
     * has
     */
    public function testHasWithUnknownIdReturnFalse()
    {
        $this->assertFalse($this->s()->has('unknownId'));
    }

    public function testHasWithKnownIdReturnTrue()
    {
        $this->s()->addDefinitions(['services' => ['knownId' => 'a service class']]);
        $this->assertFalse($this->s()->has('unknownId'));
    }

    /**
     * get
     */
    public function testGetWithUnknownIdThrowRuntimeException()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('service id "unknownId" not exists');
        $this->s()->get('unknownId');
    }

    public function testGetWithSuccessReturnSingleton()
    {
        $this->initContainerForTest();
        $service = $this->s()->get('dummy');
        $this->assertInstanceOf(\DummyConfig::class, $service);
    }

    public function testGetReturnSingleton()
    {
        $this->initContainerForTest();
        $service = $this->s()->get('dummy');
        $service2 = $this->s()->get('dummy');

        $this->assertEquals($service, $service2);
    }

    public function testGetWithConfigurableServiceReturnSingleton()
    {
        $this->initContainerForTest();
        $service = $this->s()->get('dummyConfig');
        $this->assertEquals('is configured', $this->getProtectedValue($service, 'config'));
    }

}