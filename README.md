# Config component

如果您的应用需要从不同类型的文件中读取配置并且需要将配置写回到文件中，那么该组件可以帮助您轻松实现该功能；组件目前支持的文件类型有php、json、ini;在后续的版本中更多的文件类型将会被支持。

###安装

在composer.json中添加

    {
        "require": {
            "slince/config": "dev-master@dev"
        }
    }

### 用法
    
    //config.php
    return array(
        'key1' => 'val1',
        'key2' => 'val2'
    );

    //config.json
    {
        "key3": "val3",
        "key4": "val4"
    }

    //config.ini
    key5 = val5
    key6 = val6

    //client.php
    $repository = new Slince\Config\Repository;
    $phpParser = new Slince\Config\Parser\PhpArrayParser('config.php');
    $repository->merge($phpParser);
    $repository->merge(new Slince\Config\Parser\JsonParser('config.json'));
    $repository->merge(new Slince\Config\Parser\IniParser('config.ini'));
    
    //获取参数,键值不存在时会得到默认值，null；get方法支持自定义默认值
    echo $repository->get('key1');
    echo $repository['key2'];
    
    //设置参数
    $repository->set('key7', 'val7');
    $repository['key8'] = 'val8';
    
    //判断键值是否存在
    if ($repository->exists('key9')) {
        //***
    }
    if (isset($repository['key9'])) {
        //***
    }
    
    //删除键值
    $repository->delete('key8');
    unset($repository['key8']);
    
    //将配置写回到config.php中
    $repository->dump($phpParser);

    //清空配置
    $repository->clear();
    