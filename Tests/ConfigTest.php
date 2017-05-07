<?php
namespace Slince\Config\Tests;

use PHPUnit\Framework\TestCase;
use Slince\Config\Config;
use Slince\Config\Exception\UnsupportedFormatException;
use Slince\Config\Parser\ParserInterface;

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
        $this->assertEquals('baz', $config['foo']['bar']);
    }

    public function testLoadJsonFile()
    {
        $config = new Config();
        $config->load(__DIR__ . '/Fixtures/config.json');
        $this->assertEquals('bar', $config->get('foo'));
    }

    public function testLoadXmlFile()
    {
        $config = new Config();
        $config->load(__DIR__ . '/Fixtures/config.xml');
        $this->assertEquals('bar', $config['foo']);
    }

    public function testLoadYamlFile()
    {
        $config = new Config();
        $config->load(__DIR__ . '/Fixtures/config.yml');
        $this->assertEquals('bar', $config->get('foo'));
    }

    public function testDumpPHPFile()
    {
        $config = new Config();
        $config->merge([
            'foo' => 'bar',
            'bar' => [
                'foo',
                'bar',
                'baz'
            ]
        ]);
        $targetFile = __DIR__ . '/Tmp/config-dump.php';
        $this->assertTrue($config->dump($targetFile));
        $this->assertEquals($config->toArray(), (new Config($targetFile))->toArray());
    }

    public function testDumpIniFile()
    {
        $config = new Config();
        $config->merge([
            'foo' => [
                'bar' => [
                    'foo',
                    'bar',
                    'baz'
                ]
            ]
        ]);
        $targetFile = __DIR__ . '/Tmp/config-dump.ini';
        $this->assertTrue($config->dump($targetFile));
        $this->assertEquals($config->toArray(), (new Config($targetFile))->toArray());
    }

    public function testDumpJsonFile()
    {
        $config = new Config();
        $config->merge([
            'foo' => 'bar',
            'bar' => [
                'foo',
                'bar',
                'baz'
            ]
        ]);
        $targetFile = __DIR__ . '/Tmp/config-dump.json';
        $this->assertTrue($config->dump($targetFile));
        $this->assertEquals($config->toArray(), (new Config($targetFile))->toArray());
    }

    public function testDumpXmlFile()
    {
        $config = new Config();
        $config->merge([
            'foo' => 'bar',
            'bar' => [
                'foo',
                'bar',
                'baz'
            ]
        ]);
        $targetFile = __DIR__ . '/Tmp/config-dump.xml';
        $this->assertTrue($config->dump($targetFile));
        $this->assertEquals($config->toArray(), (new Config($targetFile))->toArray());
    }

    public function testDumpYamlFile()
    {
        $config = new Config();
        $config->merge([
            'foo' => 'bar',
            'bar' => [
                'foo',
                'bar',
                'baz'
            ]
        ]);
        $targetFile = __DIR__ . '/Tmp/config-dump.yaml';
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
        new Config(__DIR__ . '/Fixtures/config.ext');
    }

    public function testAddParser()
    {
        Config::addParser(new FooParser());
        $config = new Config();
        $config->load(__DIR__ . '/Fixtures/config.ext');
        $this->assertEquals('baz', $config->get('foo'));
    }
}

class FooParser implements ParserInterface
{
    public function parse($file)
    {
        return [
            'foo' => 'baz'
        ];
    }

    public function dump($file, array $data)
    {
    }

    public static function getSupportedExtensions()
    {
        return ['ext'];
    }
}
