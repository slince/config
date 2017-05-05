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
    public function parse($filePath)
    {
        $data = json_decode(file_get_contents($filePath), true);
        if (json_last_error() != JSON_ERROR_NONE) {
            throw new ParseException(sprintf('The file (%s)  need to contain a valid json string', $filePath));
        }
        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function dump($filePath, array $data)
    {
        $string = json_encode($data);
        return @file_put_contents($filePath, $string);
    }

    /**
     * {@inheritdoc}
     */
    public static function getSupportedExtensions()
    {
        return ['json'];
    }
}