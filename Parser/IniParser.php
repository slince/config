<?php
/**
 * slince config library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Config\Parser;

use Slince\Config\Exception\InvalidArgumentException;
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
        }
        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function dump($file, array $data)
    {
        $iniString = static::writeToString($data);
        @mkdir(dirname($file), 0777, true);
        return @file_put_contents($file, $iniString) !== false;
    }

    /**
     * Writes an array configuration to a INI string and returns it.
     * The array provided must be multidimensional, indexed by section names:
     * ```
     * array(
     *     'Section 1' => array(
     *         'value1' => 'hello',
     *         'value2' => 'world',
     *     ),
     *     'Section 2' => array(
     *         'value3' => 'foo',
     *     )
     * );
     * ```
     * @link https://github.com/piwik/component-ini/blob/master/src/IniWriter.php
     * @param array $config
     * @param string $header Optional header to insert at the top of the file.
     * @return string
     */
    public static function writeToString(array $config, $header = '')
    {
        $ini = $header;
        $sectionNames = array_keys($config);
        foreach ($sectionNames as $sectionName) {
            $section = $config[$sectionName];
            if (empty($section)) {
                continue;
            }
            if (!is_array($section)) {
                throw new InvalidArgumentException(sprintf('Section "%s" does not contain an array of values', $sectionName));
            }
            $ini .= "[$sectionName]\n";
            foreach ($section as $option => $value) {
                if (is_numeric($option)) {
                    $option = $sectionName;
                    $value = array($value);
                }
                if (is_array($value)) {
                    foreach ($value as $currentValue) {
                        $ini .= $option . '[] = ' . static::formatValue($currentValue) . "\n";
                    }
                } else {
                    $ini .= $option . ' = ' . static::formatValue($value) . "\n";
                }
            }
            $ini .= "\n";
        }
        return $ini;
    }

    /**
     * Formats value
     * @param $value
     * @return int|string
     */
    protected static function formatValue($value)
    {
        if (is_bool($value)) {
            return (int) $value;
        }
        if (is_string($value)) {
            return "\"$value\"";
        }
        return $value;
    }
    
    /**
     * {@inheritdoc}
     */
    static function getSupportedExtensions()
    {
        return ['ini'];
    }
}
