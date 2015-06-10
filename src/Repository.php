<?php
/**
 * slince config component
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Config;

use Slince\Config\DataObject;
use Slince\Config\ParserFactory;
use Slince\Config\File\FileInterface;

class Repository
{
    /**
     * 当前实例
     * 
     * @var Repository
     */
    static private $_instance;
    
    /**
     * 配置的值
     *
     * @var DataObject
     */
    private $_dataObject;
    
    /**
     * 解析器
     * @var array
     */
    private $_parsers = [];

    function __construct(FileInterface $file = null)
    {
        $this->_dataObject = DataObject::create();
        if (! is_null($file)) {
            $this->parse($file);
        }
    }
    /**
     * 单例模式
     */
    static function newInstance()
    {
        if (! self::$_instance instanceof self) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    /**
     * 获取已知解析器
     * @param string $name
     */
    function getParser($name)
    {
        if (! isset($this->_parsers[$name])) {
            $this->_parsers[$name] = ParserFactory::create($name);
        }
        return $this->_parsers[$name];
    }
    
    /**
     * 解析文件数据
     * @param FileInterface $file
     */
    function parse(FileInterface $file)
    {
        $this->_dataObject->merge($this->getParser($file::FILE_TYPE)->parse($file));
    }
    
    /**
     * 添加新的配置接口或数据
     *
     * @param ParserInterface|array $data            
     * @param string $key
     * @return void
     */
    function merge($data, $key = null)
    {
        if ($data instanceof FileInterface) {
            $data =  $this->getParser($data::FILE_TYPE)->parse($data);
        }
        if (! is_null($key)) {
            $data = [$key => $data];
        }
        $this->_dataObject->merge($data);
    }

    /**
     * 将当前对象中保存的值导出
     *
     * @param FileInterface $file
     */
    function dump(FileInterface $file)
    {
        return $this->getParser($file::FILE_TYPE)->dump($file, $this->_dataObject->toArray());
    }
    
    /**
     * 数据对象
     * @return DataObject
     */
    function getDataObject()
    {
        return $this->_dataObject;
    }
}