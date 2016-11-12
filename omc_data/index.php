<?php

require_once __DIR__.'/vendor/autoload.php';

$app = new Silex\Application();

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'dbs.options' => array(
        'default' => array(
            'host'      => 'mysql_host',
            'dbname'    => 'omc',
            'user'      => 'omc',
            'password'  => 'JLKPzXoBYzj94J',
            'charset'   => 'utf8',
        )
    ),
));

$app['debug'] = true;

##### JSON Export #####
require_once __DIR__.'/omc_json_export.php';

##### Modulkatalog #####
require_once __DIR__.'/omc_modules.php';