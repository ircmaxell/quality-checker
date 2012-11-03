<?php

require_once __DIR__ . '/../vendor/autoload.php';

$al = new Composer\Autoload\ClassLoader;
$al->add('QualityChecker', __DIR__ . '/../lib');
$al->register();

$app = new Silex\Application();

$app->get('/test/parse', function() use ($app) {
    $parser = new QualityChecker\Stats;
    var_dump($parser->getStats('/Users/anthony/Dropbox/WorkNetbeans/QualityChecker/tmp/gh_18'));
    return 'yup';
});

$app->get('/test/dl', function() use ($app) {
    $provider = new QualityChecker\Provider\GitHub;
    $dir = $provider->getDirectory("https://github.com/ircmaxell/PHP-PasswordLib");
    return $dir;
});

$app->run();