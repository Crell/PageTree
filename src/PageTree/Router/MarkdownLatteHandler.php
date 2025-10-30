<?php

declare(strict_types=1);

namespace Crell\PageTree\PageTree\Router;

use Crell\PageTree\Config\MarkdownLatteConfiguration;
use Crell\PageTree\LatteTheme\LatteThemeExtension;
use Crell\PageTree\MarkdownDeserializer\MarkdownPageLoader;
use Crell\PageTree\PageTree\Page;
use Crell\PageTree\PageTree\PhysicalPath;
use Crell\PageTree\Router\RouteResult;
use Crell\PageTree\Router\RouteSuccess;
use Crell\PageTree\Services\ResponseBuilder;
use Crell\PageTree\Services\TemplateRenderer;
use Latte\Runtime\Html;
use League\CommonMark\ConverterInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class MarkdownLatteHandler implements PageHandler
{
    public private(set) array $supportedMethods = ['GET'];
    public private(set) array $supportedExtensions = ['md'];

    public function __construct(
        private readonly ResponseBuilder $builder,
        private readonly MarkdownPageLoader $loader,
        private readonly LatteThemeExtension $themeExtension,
        private readonly TemplateRenderer $renderer,
        private readonly MarkdownLatteConfiguration $config,
        private readonly ConverterInterface $converter,
    ) {}

    public function handle(ServerRequestInterface $request, Page $page, string $ext): ?RouteResult
    {
        return new RouteSuccess(
            action: $this->action(...),
            method: 'GET',
            vars: [
                'file' => $page->variant($ext)->physicalPath,
                'page' => $page,
            ],
        );
    }

    public function action(ServerRequestInterface $request, Page $page, PhysicalPath $file): ResponseInterface
    {
        return $this->builder->handleCacheableFileRequest($request, (string)$file, function() use ($file, $page) {
            $mdPage = $this->loader->load((string)$file);

            $template = $this->themeExtension->findTemplatePath($page->other['template'] ?? $this->config->defaultPageTemplate);

            $args['currentPage'] = $page;
            // Pre-render the Content rather than making the template do it.
            $args['content'] = new Html($this->converter->convert($mdPage->content));

            $args['extraStyles'][] = sprintf('%s', $this->config->codeThemeStyles);

            $result = $this->renderer->render($template, $args);

            return $this->builder->ok($result->content, $result->contentType);
        });
    }
}
