<?php
use Slince\Config\Config;

class PhpArrayTest extends \PHPUnit_Framework_TestCase
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
        $this->_config->load(__DIR__ . '/config/config.php');
        $this->assertNotEmpty($this->_config->toArray());
        $this->_config->load(__DIR__ . '/config/config2.php');
        $this->assertNotEmpty($this->_config->toArray());
    }
    
    public function testException()
    {
        $this->setExpectedException('Slince\Config\Exception\ParseException');
        $this->_config->load(__DIR__ . '/config/config3.php');
    }
}