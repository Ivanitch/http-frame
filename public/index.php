<?php

use App\Benchmark\Timer;
use Framework\Http\Application;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;


/**
 * @var \Psr\Container\ContainerInterface $container
 * @var \Framework\Http\Application $app
 */

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

Timer::start();
$memory = memory_get_usage();

$container = require 'config/container.php';
$app = $container->get(Application::class);

require 'config/pipeline.php';
require 'config/routes.php';

$request = ServerRequestFactory::fromGlobals();
$response = $app->handle($request);

$emitter = new SapiEmitter();
$emitter->emit($response);


$memory = memory_get_usage() - $memory;
$name = array('байт', 'КБ', 'МБ');
$i = 0;
while (floor($memory / 1024) > 0) {
    $i++;
    $memory /= 1024;
}

echo 'Время выполнения скрипта: ' . Timer::finish() . ' sec.<br>';
echo 'Скушано памяти: ' . round($memory, 2) . ' ' . $name[$i];
