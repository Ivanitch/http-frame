<?php

namespace Tests\Framework\Http;

use Framework\Http\Application;
use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Router\Router;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;


class ApplicationTest extends TestCase
{
    /**
     * @var MiddlewareResolver
     */
    private $resolver;
    /**
     * @var Router
     */
    private $router;

    public function setUp(): void
    {
        parent::setUp();
        $this->resolver = new MiddlewareResolver(new DummyContainer(), new Response());
        $this->router = $this->createMock(Router::class);
    }

    public function testPipe(): void
    {
        $app = new Application($this->resolver, $this->router, new DefaultHandler());

        $app->pipe(new Middleware1());
        $app->pipe(new Middleware2());

        $response = $app->handle(new ServerRequest());

        $this->assertJsonStringEqualsJsonString(
            json_encode(['middleware-1' => 1, 'middleware-2' => 2]),
            $response->getBody()->getContents()
        );
    }
}

class Middleware1 implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $handler->handle($request->withAttribute('middleware-1', 1));
    }
}

class Middleware2 implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $handler->handle($request->withAttribute('middleware-2', 2));
    }
}

class DefaultHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse($request->getAttributes());
    }
}
