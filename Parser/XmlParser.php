<?php
/**
 * slince config library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Config\Parser;

use LSS\Array2XML;
use LSS\XML2Array;
use Slince\Config\Exception\ParseException;

class XmlParser implements ParserInterface
{
    /**
     * The xml root node name
     * @var string
     */
    public static $rootNodeName = 'configuration';

    /**
     * {@inheritdoc}
     */
    public function parse($file)
    {
        $xml = file_get_contents($file);
        try {
            $data = XML2Array::createArray($xml);
        } catch (\Exception $exception) {
            throw new ParseException($exception->getMessage(), $exception->getCode());
        }
        return reset($data);
    }

    /**
     * {@inheritdoc}
     */
    public function dump($file, array $data)
    {
        $xml = Array2XML::createXML(static::$rootNodeName, $data);
        @mkdir(dirname($file), 0777, true);
        return @file_put_contents($file, $xml->saveXML()) !== false;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSupportedExtensions()
    {
        return ['xml'];
    }
}