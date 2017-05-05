<?php
use Slince\Config\Config;

class JsonTest extends \PHPUnit_Framework_TestCase
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
        $this->_config->load(__DIR__ . '/config/config.json');
        $this->assertNotEmpty($this->_config->toArray());
    }

    public function testException()
    {
        $this->setExpectedException('Slince\Config\Exception\ParseException');
        $this->_config->load(__DIR__ . '/config/config2.json');
    }

//     public function testDump()
//     {
//         $this->_config->merge(new JsonFile(__DIR__ . '/config/config.json'));
//         $this->_config->getDataObject()->set('key5', 'value5');
//         $this->_config->getDataObject()->set('key6', 'value6');
//         $this->_config->dump(new JsonFile(__DIR__ . '/config/config-dump.json'));
//     }
}