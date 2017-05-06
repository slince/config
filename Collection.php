<?php
/**
 * slince config component
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Config;

class Collection implements \ArrayAccess, \Countable, \IteratorAggregate
{
    /**
     * Array of data
     * @var array
     */
    protected $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * Returns data
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * Sets a item with its key and value
     * @param int|string $key
     * @param mixed $value
     * @return void
     */
    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * Gets the value by the specified key
     * @param int|string $key
     * @param mixed $defaultValue            
     * @return mixed
     */
    public function get($key, $defaultValue = null)
    {
        return $this->exists($key) ? $this->data[$key] : $defaultValue;
    }

    /**
     * Merges a array to the collection
     * @param array $data
     */
    public function merge(array $data)
    {
        $this->data = array_replace($this->data, $data);
    }

    /**
     * Checks whether the item exists
     * @param int|string $key
     * @return boolean
     */
    public function exists($key)
    {
        return isset($this->data[$key]);
    }

    /**
     * Remove a item by its key
     * @param mixed $key
     */
    public function delete($key)
    {
        unset($this->data[$key]);
    }

    /**
     * Clears the collection
     */
    public function clear()
    {
        $this->data = [];
    }

    /**
     * Clears the collection
     * @deprecated
     */
    public function flush()
    {
        $this->clear();
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        $this->delete($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return $this->exists($offset);
    }


    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->data);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->data);
    }
}