<?php
$app->register(new Silex\Provider\SessionServiceProvider());
$dataFactory = new CRUDlex\MySQLDataFactory($app['db']);
$app->register(new CRUDlex\ServiceProvider(), array(
    'crud.file' => __DIR__ . '/omc.yml',
    'crud.datafactory' => $dataFactory
));
$app->register(new Silex\Provider\TwigServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/tpl'
));
$app['crud.layout'] = 'layout.twig';
$app['crud.template.list.modules'] = 'list.twig';
$app->mount('/omc', new CRUDlex\ControllerProvider());
$app->match('/', function() use ($app) {
    return $app->redirect($app['url_generator']->generate('crudList', array('entity' => 'modules')));
})->bind('homepage');
$app->run();