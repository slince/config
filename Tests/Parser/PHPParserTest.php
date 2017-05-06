<?php
namespace Slince\Config\Tests\Parser;

use PHPUnit\Framework\TestCase;
use Slince\Config\Exception\ParseException;
use Slince\Config\Parser\PHPParser;

class PHPParserTest extends TestCase
{
    public function testParse()
    {
        $parser = new PHPParser();
        $data = $parser->parse(__DIR__ . '/../Fixtures/config.php');
        $this->assertEquals([
            'foo' => 'bar',
            'bar' => 'baz',
        ], $data);
    }

    public function testException()
    {
        $this->setExpectedException(ParseException::class);
        (new PHPParser())->parse(__DIR__ . '/../Fixtures/no_return_array.php');
    }

    public function testDump()
    {
        $parser = new PHPParser();
        $file = __DIR__ . '/../Tmp/php-dump.php';
        $this->assertTrue($parser->dump($file, [
            'foo' => 'bar'
        ]));
        $this->assertEquals([
            'foo' => 'bar'
        ], $parser->parse($file));
    }
}