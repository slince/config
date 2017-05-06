<?php
namespace Slince\Config\Tests\Parser;

use PHPUnit\Framework\TestCase;
use Slince\Config\Config;
use Slince\Config\Exception\ParseException;
use Slince\Config\Parser\JsonParser;

class JsonParserTest extends TestCase
{

    public function testParse()
    {
        $parser = new JsonParser();
        $data = $parser->parse(__DIR__ . '/../Fixtures/config.json');
        $this->assertEquals([
            'foo' => 'bar',
            'bar' => 'baz',
        ], $data);
    }

    public function testException()
    {
        $this->setExpectedException(ParseException::class);
        (new JsonParser())->parse(__DIR__ . '/../Fixtures/syntax_error_json_file.json');
    }

     public function testDump()
     {
         $parser = new JsonParser();
         $file = __DIR__ . '/../Tmp/json-dump.json';
         $this->assertTrue($parser->dump($file, [
             'foo' => 'bar'
         ]));
         $this->assertEquals([
             'foo' => 'bar'
         ], $parser->parse($file));
     }
}