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
        $this->assertEquals('bar', $data['foo']);
    }

    public function testException()
    {
        $parser = new IniParser();
        $this->setExpectedException(ParseException::class);
        $parser->parse(__DIR__ . '/../Fixtures/syntax_error_ini_file.ini');
    }

    public function testDump()
    {
        $parser = new IniParser();
        $this->setExpectedException(ParseException::class);
        $parser->dump(__DIR__ . '/../Tmp/ini-dump.ini', [
            'foo' => 'bar'
        ]);
    }
}