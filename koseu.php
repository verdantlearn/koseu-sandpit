<?php

/*
 * Koseu - An entire LMS in a single file + .htaccess
 */

use \Tsugi\Core\LTIX;

define('COOKIE_SESSION', true);
require_once "tsugi/config.php";

$launch = LTIX::session_start();
$app = new \Tsugi\Silex\Application($launch);
$app['debug'] = true;

$app->get('/foo', function() {
    return 'foo';
})->bind("foo"); // this is the route name

$app->get('/redirect', function() use ($app) {
    // return $app->redirectRoute('/foo');
    return $app->redirect($app['url_generator']->generate('foo', array('x' => 2) ) );
});

$app->get('/class/{name}', function ($name) use ($app) {
    return $app['twig']->render('page.twig', array(
        'tsugi' => $app['tsugi'],
        'name' => $name,
    ));
});

// echo("<pre>\n"); var_dump($app); echo("</pre>\n");
$app->get('/dump', function () use ($app) {
    return $app['twig']->render('@Tsugi/Dump.twig');
});

$app->run();
