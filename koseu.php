<?php

/*
 * Koseu - An entire LMS in a single file + .htaccess
 */

use \Tsugi\Core\LTIX;

define('COOKIE_SESSION', true);
require_once "tsugi/config.php";

$launch = LTIX::session_start();
$app = new \Tsugi\Silex\Application($launch);

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

$app->get('/class/{name}', function ($name) use ($app) {
    return $app['twig']->render('\myview', array(
        'tsugi' => $app['tsugi'],
        'name' => $name,
    ));
});

$app->run();
