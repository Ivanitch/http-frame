<?php

namespace Infrastructure\App\Logger;

use Psr\Container\ContainerInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class LoggerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $log = new Logger('App');
        $log->pushHandler(new StreamHandler(
            'var/log/application.log',
            $container->get('config')['debug'] ? Logger::DEBUG : Logger::WARNING
        ));
        return $log;
    }
}
