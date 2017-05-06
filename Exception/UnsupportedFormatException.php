<?php
/**
 * slince config library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Config\Exception;

class UnsupportedFormatException extends \Exception
{
    public function __construct($extension)
    {
        parent::__construct(sprintf('Unsupported configuration file format [%s]', $extension));
    }
}
