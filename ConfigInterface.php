<?php
/**
 * slince config library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Config;

interface ConfigInterface
{
    /**
     * Loads a configuration file or directory
     * @param string|array $path
     * @return $this
     */
    public function load($path);

    /**
     * Dumps all data to a configuration file
     * @param string $file
     * @return boolean
     */
    public function dump($file);
}
