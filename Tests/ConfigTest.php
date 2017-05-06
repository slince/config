<?php
namespace Slince\Config\Tests;

use PHPUnit\Framework\TestCase;
use Slince\Config\Config;
use Slince\Config\Exception\ParseException;
use Slince\Config\Exception\UnsupportedFormatException;

class ConfigTest extends TestCase
{
    public function testLoadPHPFile()
    {
        $config = new Config();
        $config->load(__DIR__ . '/Fixtures/config.php');
        $this->assertEquals('bar', $config->get('foo'));
    }

    public function testLoadIniFile()
    {
        $config = new Config();
        $config->load(__DIR__ . '/Fixtures/config.ini');
        $this->assertEquals('bar', $config->get('foo'));
    }

    public function testLoadJsonFile()
    {
        $config = new Config();
        $config->load(__DIR__ . '/Fixtures/config.json');
        $this->assertEquals('bar', $config->get('foo'));
    }

    public function testDumpPHPFile()
    {
        $config = new Config();
        $config->load(__DIR__ . '/Fixtures/config.php');
        $targetFile = __DIR__ . '/Tmp/config-dump.php';
        $this->assertTrue($config->dump($targetFile));
        $this->assertEquals($config->toArray(), (new Config($targetFile))->toArray());
    }

    public function testDumpIniFile()
    {
        $config = new Config();
        $config->load(__DIR__ . '/Fixtures/config.php');
        $targetFile = __DIR__ . '/Tmp/config-dump.ini';
        $this->setExpectedException(ParseException::class);
        $config->dump($targetFile);
    }

    public function testDumpJsonFile()
    {
        $config = new Config();
        $config->load(__DIR__ . '/Fixtures/config.php');
        $targetFile = __DIR__ . '/Tmp/config-dump.json';
        $this->assertTrue($config->dump($targetFile));
        $this->assertEquals($config->toArray(), (new Config($targetFile))->toArray());
    }

    public function testLoadDirectory()
    {
        $config = new Config(__DIR__ . '/Fixtures/config');
        $this->assertCount(3, $config);
        $this->assertEquals('bar', $config->get('foo'));
        $this->assertEquals('baz', $config->get('bar'));
        $this->assertEquals('foo', $config->get('baz'));
    }

    public function testUnsupportedFormat()
    {
        $this->setExpectedException(UnsupportedFormatException::class);
        $config = new Config(__DIR__ . '/Fixtures/config.ext');
    }
}