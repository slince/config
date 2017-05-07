<?php
/**
 * slince config library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Config\Parser;

use Slince\Config\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class YamlParser implements ParserInterface
{
    /**
     * Whether supports native function
     * @var boolean
     */
    protected static $supportNative;

    public function __construct()
    {
        if (is_null(static::$supportNative)) {
            static::$supportNative = function_exists('yaml_parse_file');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function parse($file)
    {
        if (static::$supportNative && ($data = yaml_parse_file($file)) === false) {
            throw new ParseException(sprintf('The file "%s" has syntax errors', $file));
        } else {
            try {
                $data = Yaml::parse(file_get_contents($file));
            } catch (\Exception $exception) {
                throw new ParseException($exception->getMessage(), $exception->getCode());
            }
        }
        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function dump($file, array $data)
    {
        @mkdir(dirname($file), 0777, true);
        if (static::$supportNative) {
            $result = yaml_emit_file($file, $data);
        } else {
            $yaml = Yaml::dump($data);
            $result = (@file_put_contents($file, $yaml) !== false);
        }
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSupportedExtensions()
    {
        return ['yml', 'yaml'];
    }
}