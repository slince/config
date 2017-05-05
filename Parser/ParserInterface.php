<?php
/**
 * slince config library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Config\Parser;

interface ParserInterface
{
    /**
     * Parse the configuration file to an array
     * @param string $file
     * @return array
     */
    public function parse($file);

    /**
     * Dumps the data to the configuration file
     * @param string $file
     * @param array $data
     */
    public function dump($file, array $data);

    /**
     * Gets all extensions that are supported by the parser
     * @return array
     */
    public static function getSupportedExtensions();
}