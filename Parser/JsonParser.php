<?php
/**
 * slince config library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Config\Parser;

use Slince\Config\Exception\ParseException;

class JsonParser implements ParserInterface
{
    /**
     * {@inheritdoc}
     */
    public function parse($file)
    {
        $data = json_decode(file_get_contents($file), true);
        if (json_last_error() != JSON_ERROR_NONE) {
            throw new ParseException(sprintf('The file (%s)  need to contain a valid json string', $file));
        }
        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function dump($file, array $data)
    {
        $string = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        @mkdir(dirname($file), 0777, true);
        return @file_put_contents($file, $string) !== false;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSupportedExtensions()
    {
        return ['json'];
    }
}