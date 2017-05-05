<?php
/**
 * slince config library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Config;

use Slince\Config\Exception\UnsupportedFormatException;
use Slince\Config\Exception\InvalidFileException;
use Slince\Config\Parser\IniParser;
use Slince\Config\Parser\JsonParser;
use Slince\Config\Parser\ParserInterface;
use Slince\Config\Parser\PhpParser;

class Config extends Collection implements ConfigInterface
{
    /**
     * Array of parser instances
     * @var array
     */
    protected static $parsers = [];

    /**
     * Array of supported file format parsers
     * @var array
     */
    protected static $supportedFileParsers = [
        PhpParser::class,
        IniParser::class,
        JsonParser::class
    ];

    public function __construct($path = null)
    {
        is_null($path) || $this->load($path);
    }

    /**
     * {@inheritdoc}
     */
    public function load($path)
    {
        $paths = is_array($path) ? $path : [$path];
        foreach ($paths as $path) {
            $this->data = array_replace($this->data, $this->parseFile($path));
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function dump($file)
    {
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        return static::getParser($extension)->dump($file, $this->toArray());
    }

    /**
     * Parse a configuration file or directory to an array
     * @param string|array $path
     * @return array
     * @deprecated
     */
    public function parse($path)
    {
        return $this->parseFile($path);
    }

    /**
     * Parses a configuration file or directory
     * @param string $path
     * @return array
     */
    protected function parseFile($path)
    {
        $data = [];
        $files = $this->findConfigurationFiles($path);
        foreach ($files as $file) {
            $extension = pathinfo($file, PATHINFO_EXTENSION);
            $data = array_merge($data, static::getParser($extension)->parse($file));
        }
        return $data;
    }

    /**
     * finds all supported configuration files at the directory
     * @param string $path
     * @throws InvalidFileException
     * @return array
     */
    protected function findConfigurationFiles($path)
    {
        if (is_dir($path)) {
            $files = glob($path . '/*.*');
            if (empty($files)) {
                throw new InvalidFileException(sprintf('There are no supported configuration files in the directory "%s"', $path));
            }
        } else {
            if (!file_exists($path)) {
                throw new InvalidFileException(sprintf('File "%s" does not exists', $path));
            }
            $files = [$path];
        }
        return $files;
    }

    /**
     * Gets a file parser by its extension
     * @param string $extension
     * @throws UnsupportedFormatException
     * @return ParserInterface
     */
    protected static function getParser($extension)
    {
        if (isset(static::$parsers[$extension])) {
            return static::$parsers[$extension];
        }
        foreach (static::$supportedFileParsers as $parser) {
            if (in_array($extension, call_user_func([$parser, 'getSupportedExtensions']))) {
                static::$parsers[$extension] = new $parser();
                return static::$parsers[$extension];
            }
        }
        throw new UnsupportedFormatException($extension);
    }
}