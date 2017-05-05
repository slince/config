<?php
/**
 * slince config library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Config\Parser;

use Slince\Config\Exception\ParseException;

class PhpParser implements ParserInterface
{
    /**
     * {@inheritdoc}
     */
    public function parse($filePath)
    {
        $data = include $filePath;
        if (! is_array($data)) {
            throw new ParseException(sprintf('The file "%s" must return a PHP array', $filePath));
        }
        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function dump($filePath, array $data)
    {
        $value = var_export($data, true);
$string = <<<EOT
<?php 
return {$value};
EOT;
        return @file_put_contents($filePath, $string) !== false;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSupportedExtensions()
    {
        return ['php'];
    }
}