<?php
namespace Slince\Config\Tests;

use PHPUnit\Framework\TestCase;
use Slince\Config\Collection;

class CollectionTest extends TestCase
{
    public function testToArray()
    {
        $collection = new Collection([
            'foo' => 'bar',
            'bar' => 'baz',
        ]);
        $this->assertEquals([
            'foo' => 'bar',
            'bar' => 'baz',
        ], $collection->toArray());
    }

    public function testCount()
    {
        $collection = new Collection([
            'foo' => 'bar'
        ]);
        $this->assertEquals(1, $collection->count());
        $this->assertCount(1, $collection);
    }

    public function testGet()
    {
        $collection = new Collection([
            'foo' => 'bar'
        ]);
        $this->assertEquals('bar', $collection->get('foo'));
        $this->assertEquals('bar', $collection['foo']);

        $this->assertNull($collection->get('not_exists_key'));
        $this->assertEquals('default_value', $collection->get('not_exists_key', 'default_value'));
    }

    public function testSet()
    {
        $collection = new Collection();
        $collection->set('foo', 'bar');
        $this->assertEquals('bar', $collection->get('foo'));
        $collection['bar'] = 'baz';
        $this->assertEquals('baz', $collection->get('bar'));
    }

    public function testExists()
    {
        $collection = new Collection([
            'foo' => 'bar'
        ]);
        $this->assertTrue($collection->exists('foo'));
        $this->assertTrue(isset($collection['foo']));
        $this->assertFalse($collection->exists('bar'));
        $this->assertFalse(isset($collection['bar']));
    }

    public function testDelete()
    {
        $collection = new Collection([
            'foo' => 'bar',
            'bar' => 'baz',
        ]);
        $this->assertCount(2, $collection);
        $collection->delete('foo');
        $this->assertCount(1, $collection);
        unset($collection['bar']);
        $this->assertCount(0, $collection);
    }

    public function testClear()
    {
        $collection = new Collection([
            'foo' => 'bar',
            'bar' => 'baz',
        ]);
        $collection->clear();
        $this->assertCount(0, $collection);
    }

    public function testDeepAction()
    {
        $collection = new Collection([
            'foo' => [
                'bar' => [
                    'baz' => [
                        'foo' => [
                            'bar' => 'baz'
                        ]
                    ]
                ]
            ]
        ]);
        $this->assertEquals('baz', $collection['foo']['bar']['baz']['foo']['bar']);
    }
}