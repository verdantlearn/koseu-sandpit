<?php

/*
 * Koseu - An entire LMS in a single file + .htaccess
 */

require_once "tsugi/config.php";

class myview {
    public $view = 'Hello name = {{ name }} from the \myview class';
}

$loader = new \Koseu\Twig\Twig_Loader_Class();
$app = new \Silex\Application();

$app->register(new \Silex\Provider\TwigServiceProvider(), array(
    'twig.loader' => $loader
));

$app->get('/class/{name}', function ($name) use ($app) {
    echo("<pre>\n");
    return $app['twig']->render('\myview', array(
        'name' => $name,
    ));
});

$app->run();
