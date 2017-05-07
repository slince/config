<?php
namespace Slince\Config\Tests\Parser;

use PHPUnit\Framework\TestCase;
use Slince\Config\Parser\XmlParser;
use Slince\Config\Exception\ParseException;

class XmlParserTest extends TestCase
{
    public function testParse()
    {
        $parser = new XmlParser();
        $data = $parser->parse(__DIR__ . '/../Fixtures/config.xml');
        $this->assertEquals([
            'foo' => 'bar',
            'bar' => 'baz',
        ], $data);
    }

    public function testException()
    {
        $this->setExpectedException(ParseException::class);
        (new XmlParser())->parse(__DIR__ . '/../Fixtures/syntax_error_xml_file.xml');
    }

    public function testDump()
    {
        $parser = new XmlParser();
        $file = __DIR__ . '/../Tmp/xml-dump.xml';
        $this->assertTrue($parser->dump($file, [
            'foo' => 'bar'
        ]));
        $this->assertEquals([
            'foo' => 'bar'
        ], $parser->parse($file));
    }
}