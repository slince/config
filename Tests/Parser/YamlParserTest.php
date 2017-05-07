<?php
namespace Slince\Config\Tests\Parser;

use PHPUnit\Framework\TestCase;
use Slince\Config\Parser\YamlParser;
use Slince\Config\Exception\ParseException;

class YamlParserTest extends TestCase
{
    public function testParse()
    {
        $parser = new YamlParser();
        $data = $parser->parse(__DIR__ . '/../Fixtures/config.yml');
        $this->assertEquals([
            'foo' => 'bar',
            'bar' => 'baz',
        ], $data);
    }

    public function testException()
    {
        $this->setExpectedException(ParseException::class);
        (new YamlParser())->parse(__DIR__ . '/../Fixtures/syntax_error_json_file.json');
    }

    public function testDump()
    {
        $parser = new YamlParser();
        $file = __DIR__ . '/../Tmp/yaml-dump.yml';
        $this->assertTrue($parser->dump($file, [
            'foo' => 'bar'
        ]));
        $this->assertEquals([
            'foo' => 'bar'
        ], $parser->parse($file));
    }
}