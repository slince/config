<?php
/**
 * slince config component
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Config;

class Collection implements \ArrayAccess, \Countable, \IteratorAggregate
{
    /**
     * 配置的值
     *
     * @var array
     */
    protected $data = [];

    /**
     * 输出当前对象中保存的配置值
     *
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * 替换当前数据
     * 
     * @param array $data            
     */
    public function replace(array $data)
    {
        $this->data = $data;
    }

    /**
     * 设置新的配置值，已存在的键值将会被覆盖
     *
     * @param int|string $key            
     * @param mixed $value            
     * @return void
     */
    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * 获取某个键值对应的参数
     *
     * @param int|string $key            
     * @param mixed $defaultValue            
     * @return mixed
     */
    public function get($key, $defaultValue = null)
    {
        return $this->exists($key) ? $this->data[$key] : $defaultValue;
    }

    /**
     * 批量合并
     * 
     * @param array $data            
     */
    public function merge(array $data)
    {
        $this->data = array_merge($this->data, $data);
    }

    /**
     * 判断是否存在某个键值
     * @param int|string $key
     * @return boolean
     */
    public function exists($key)
    {
        return isset($this->data[$key]);
    }

    /**
     * 移除已存在的键值
     * @param mixed $key
     */
    public function delete($key)
    {
        unset($this->data[$key]);
    }

    /**
     * 清除所有的数据
     * @return void
     */
    public function flush()
    {
        $this->data = [];
    }


    /**
     * 继承方法
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * 继承方法
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    /**
     * 继承方法
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        $this->delete($offset);
    }

    /**
     * 继承方法
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return $this->exists($offset);
    }


    /**
     * 继承方法
     * @return mixed
     */
    public function count()
    {
        return count($this->data);
    }

    /**
     * 继承方法
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->data);
    }
}