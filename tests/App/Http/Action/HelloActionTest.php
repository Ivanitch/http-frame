<?php

namespace Tests\App\Http\Action;

use App\Http\Action\HelloAction;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Template\PhpRenderer;
use PHPUnit\Framework\TestCase;
use Aura\Router\RouterContainer;

class HelloActionTest extends TestCase
{
    private $renderer;


    protected function setUp(): void
    {
        parent::setUp();
        $this->renderer = new PhpRenderer('templates', new AuraRouterAdapter(new RouterContainer()));
    }
    public function test()
    {
        $action = new HelloAction($this->renderer);
        $response = $action();

        self::assertEquals(200, $response->getStatusCode());
        self::assertContains('Hello!', $response->getBody()->getContents());
    }
}