<?php

namespace Infrastructure\Framework\Http\Middleware\ErrorHandler;

use Psr\Container\ContainerInterface;
use Laminas\Diactoros\Response;
use Whoops\RunInterface;
use Framework\Http\Middleware\ErrorHandler\WhoopsErrorResponseGenerator;

class WhoopsErrorResponseGeneratorFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new WhoopsErrorResponseGenerator(
            $container->get(RunInterface::class),
            new Response()
        );
    }
}
