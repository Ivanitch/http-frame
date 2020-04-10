<?php

namespace App\Http\Action\Blog;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use App\ReadModel\Pagination;
use App\ReadModel\PostReadRepository;
use Framework\Template\TemplateRenderer;

class IndexAction implements RequestHandlerInterface
{
    const PER_PAGE = 20;

    private $posts;
    private $template;

    public function __construct(PostReadRepository $posts, TemplateRenderer $template)
    {
        $this->posts = $posts;
        $this->template = $template;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $pager = new Pagination(
            $this->posts->countAll(),
            $request->getAttribute('page') ?: 1,
            self::PER_PAGE
        );

        $posts = $this->posts->all(
            $pager->getOffset(),
            $pager->getLimit()
        );

        return new HtmlResponse($this->template->render('app/blog/index', [
            'posts' => $posts,
            'pager' => $pager,
        ]));
    }
}
