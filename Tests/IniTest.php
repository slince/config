<?php
use Slince\Config\Config;

class IniTest extends \PHPUnit_Framework_TestCase
{

    private $_config;

    public function setUp()
    {
        $this->_config = new Config();
    }

    public function tearDown()
    {
        unset($this->_config);
    }

    public function testMerge()
    {
        $this->_config->load(__DIR__ . '/config/config.ini');
        $this->assertNotEmpty($this->_config->toArray());
    }

    public function testException()
    {
        $this->setExpectedException('Slince\Config\Exception\ParseException');
        $this->_config->load(__DIR__ . '/config/config2.ini');
    }

    /**
     * @expectedException Slince\Config\Exception\ParseException
     */
    public function testDump()
    {
        $this->_config->load(__DIR__ . '/config/config.ini');
        $this->_config->set('key5', 'value5');
        $this->_config->set('key6', 'value6');
        $this->setExpectedException('Slince\Config\Exception\ParseException');
        $this->_config->dump(__DIR__ . '/config/config-dump.ini');
    }
}