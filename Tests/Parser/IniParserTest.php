<?php
namespace Slince\Config\Tests\Parser;

use PHPUnit\Framework\TestCase;
use Slince\Config\Exception\ParseException;
use Slince\Config\Parser\IniParser;

class IniParserTest extends TestCase
{
    public function testParse()
    {
        $parser = new IniParser();
        $data = $parser->parse(__DIR__ . '/../Fixtures/config.ini');
        $this->assertEquals('baz', $data['foo']['bar']);
    }

    public function testException()
    {
        $this->setExpectedException(ParseException::class);
        (new IniParser())->parse(__DIR__ . '/../Fixtures/syntax_error_ini_file.ini');
    }

    public function testDump()
    {
        $parser = new IniParser();
        $file = __DIR__ . '/../Tmp/ini-dump.ini';
        $this->assertTrue($parser->dump($file, [
            'foo' => [
                'bar' => [
                    'foo',
                    'bar',
                    'baz'
                ]
            ]
        ]));
        $this->assertEquals([
            'foo' => [
                'bar' => [
                    'foo',
                    'bar',
                    'baz'
                ]
            ]
        ], $parser->parse($file));
    }

    public function testWriteToString()
    {
        $config = array(
            'Section 1' => array(
                'foo' => 'bar',
                'bool_true' => true,
                'bool_false' => false,
                'int' => 10,
                'float' => 10.3,
                'array' => array(
                    'string',
                    10.3,
                    true,
                    false,
                ),
            ),
            'Section 2' => array(
                'foo' => 'bar',
            ),
        );
        $expected = <<<EOT
[Section 1]
foo = "bar"
bool_true = 1
bool_false = 0
int = 10
float = 10.3
array[] = "string"
array[] = 10.3
array[] = 1
array[] = 0

[Section 2]
foo = "bar"
EOT;
        $this->assertEquals(parse_ini_string($expected, true),
            parse_ini_string(IniParser::writeToString($config), true));
    }
}
