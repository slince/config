# Configuration File Loader

[![Build Status](https://img.shields.io/travis/slince/config/master.svg?style=flat-square)](https://travis-ci.org/slince/config)
[![Coverage Status](https://img.shields.io/codecov/c/github/slince/config.svg?style=flat-square)](https://codecov.io/github/slince/config)
[![Latest Stable Version](https://img.shields.io/packagist/v/slince/config.svg?style=flat-square&label=stable)](https://packagist.org/packages/slince/config)
[![Scrutinizer](https://img.shields.io/scrutinizer/g/slince/config.svg?style=flat-square)](https://scrutinizer-ci.com/g/slince/config/?branch=master)

The library support multiple configuration file formats like json,ini,xml,yaml and native php array. It can also help to dump 
items to the specified configuration file.

### Installation

Install via composer

```json
{
    "require": {
        "slince/config": "^1.0"
    }
}
```

### Usage

#### Creates a config instance

```php
$config = new Slince\Config\Config();
```

#### Load configuration files

Loads a configuration file

```php
$config->load('/path/to/config.json');
```

Loads a directory that contains multiple files

```php
$config->load('/path/to/config-directory/');
```
> Notes: The directory can't contain unsupported files.


### Access data

```php
$config->get('foo');

//Or access the data like array
$config['foo']['bar'];
```

Checks whether a item exists by its key

```php
echo $config->exists('foo');

//or like array
echo isset($config['foo']);
```

Adds a item to the container

```php
$config->set('bar', 'baz');

//or like array
$config['bar'] = 'baz';
```

Removes a item by its key

```php
$config->delete('bar');

//or like array
unset($config['bar']);
```

Removes all items

```php
$config->clear();
```

#### Dumps all items to an specified configuration file

```php
$config->dump('/path/to/config-dump.php');
```

### License

The MIT license. See [MIT](https://opensource.org/licenses/MIT)