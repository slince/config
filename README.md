# Configuration File Loader

[![Build Status](https://img.shields.io/travis/slince/config/master.svg?style=flat-square)](https://travis-ci.org/slince/config)
[![Coverage Status](https://img.shields.io/codecov/c/github/slince/config.svg?style=flat-square)](https://codecov.io/github/slince/config)
[![Latest Stable Version](https://img.shields.io/packagist/v/slince/config.svg?style=flat-square&label=stable)](https://packagist.org/packages/slince/config)
[![Scrutinizer](https://img.shields.io/scrutinizer/g/slince/config.svg?style=flat-square)](https://scrutinizer-ci.com/g/slince/config/?branch=master)

The library support multiple configuration file formats like json,ini and php array;

### Installation

Install via composer

```shell
{
    "require": {
        "slince/config": "*"
    }
}
```

### Usage

#### Creates a config instance

```
$config = new Slince\Config\Config();
```

#### Load configuration files

Load a configuration file

```
$config->load('/path/to/config.json');
```

You can also load a directory that contains multiple files

```
$config->load('/path/to/config-directory/');
```
> Notes: The directory can't contain unsupported files.


### Access data

```
$config->get('foo');
```
Or access the data like array

```
$config['foo']['bar'];
```

Checks whether a item exists by its key

```
echo $config->exists('foo');

// Or like array

echo isset($config['foo']);
```
