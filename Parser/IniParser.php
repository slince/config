<?php
/**
 * slince config library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Config\Parser;

use Slince\Config\Exception\ParseException;

class IniParser implements ParserInterface
{
    /**
     * {@inheritdoc}
     */
    public function parse($file)
    {
        if (($data = @parse_ini_file($file, true)) === false) {
            throw new ParseException(sprintf('The file "%s" has syntax errors', $file));
        } else {
            return $data;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function dump($filePath, array $data)
    {
        throw new ParseException('Not supported');
    }
    
    /**
     * {@inheritdoc}
     */
    static function getSupportedExtensions()
    {
        return ['ini'];
    }
}