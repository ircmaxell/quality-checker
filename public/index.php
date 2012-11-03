<?php

require_once __DIR__ . '/../vendor/autoload.php';

$al = new Composer\Autoload\ClassLoader;
$al->add('QualityChecker', __DIR__ . '/../lib');
$al->register();

$app = new Silex\Application();

$app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__ . '/views'));

$app->register(new Silex\Provider\DoctrineServiceProvider);
$app['debug'] = true;

$app['db.options'] = array(
    'driver' => 'mongo',
    'dbname' => 'quality',
);

$app->before(function() use ($app) {
    $app['db.repos'] = $app->share(function($app) {
        return new QualityChecker\Repository\Repos($app['db']);
    });
});

$app->get('/', function() use ($app) {
var_dump("hi!");
    $data = $app['db.repos']->findAll();
    var_dump($data);
    return $app['twig']->render('index.twig', array(
        'data' => $data
    ));
});

$app->get('/test/run', function() use ($app) {
    $url = "https://github.com/ircmaxell/PHP-PasswordLib";
    $provider = new QualityChecker\Parser\GitHub;
    $dir = $provider->getDirectory($url);
    $parser = new QualityChecker\Parser\Stats;
    $stats = $parser->getStats($dir, $url);
    $app['db.repos']->
    $storage = new QualityChecker\Mapper\Storage;
    $storage->store($stats);
    return 'Yay!';
});

$app->run();