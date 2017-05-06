<?php
/**
 * slince config library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Config\Parser;

use Slince\Config\Exception\ParseException;

class PHPParser implements ParserInterface
{
    /**
     * {@inheritdoc}
     */
    public function parse($file)
    {
        $data = include $file;
        if (!is_array($data)) {
            throw new ParseException(sprintf('The file "%s" must return a PHP array', $file));
        }
        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function dump($file, array $data)
    {
        $value = var_export($data, true);
        $string = <<<EOT
<?php 
return {$value};
EOT;
        @mkdir(dirname($file), 0777, true);
        return @file_put_contents($file, $string) !== false;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSupportedExtensions()
    {
        return ['php'];
    }
}
