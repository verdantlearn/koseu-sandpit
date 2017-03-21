<?php

/*
 * Koseu - An entire LMS in a single file + .htaccess
 */

use \Tsugi\Core\LTIX;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\PhpBridgeSessionStorage;

define('COOKIE_SESSION', true);
require_once "tsugi/config.php";

$app = new \Silex\Application();
$app['tsugi'] = LTIX::session_start();
$OUTPUT->buffer = true;

$session = new Session(new PhpBridgeSessionStorage());
$session->start();
$app['session'] = $session;

class TsugiPage {
    public $view = '{{ tsugi.output.header | raw }}
{% block head %}
{% endblock %}
{{ tsugi.output.bodyStart | raw }} 
{{ tsugi.output.topNav() | raw }} 
{% block content %}{% endblock %}
{{ tsugi.output.footerStart() | raw }}
{% block footer %}
{% endblock %}
{{ tsugi.output.footerEnd() | raw }}
';
}

class myview {
    public $view = '
{% extends "\TsugiPage" %}

{% block content %}
Hello name = {{ name }} from the \myview class
{% endblock %}
';
}

$loader = new \Koseu\Twig\Twig_Loader_Class();
$app->tsugi = $LAUNCH;

$app->register(new \Silex\Provider\TwigServiceProvider(), array(
    'twig.loader' => $loader
));

$app->get('/class/{name}', function ($name) use ($app) {
    return $app['twig']->render('\myview', array(
        'tsugi' => $app['tsugi'],
        'name' => $name,
    ));
});

$app->run();
