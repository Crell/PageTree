<?php

declare(strict_types=1);

namespace Crell\PageTree\PageTree\Router;

use Crell\PageTree\Config\StaticRoutes;
use Crell\PageTree\PageTree\Page;
use Crell\PageTree\PageTree\PhysicalPath;
use Crell\PageTree\Router\RouteResult;
use Crell\PageTree\Router\RouteSuccess;
use Crell\PageTree\Services\ResponseBuilder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

class StaticFileHandler implements PageHandler
{
    public private(set) array $supportedMethods = ['GET'];
    public array $supportedExtensions {
        get => array_keys($this->config->allowedExtensions);
    }

    public function __construct(
        private readonly ResponseBuilder $builder,
        private readonly StreamFactoryInterface $streamFactory,
        private readonly StaticRoutes $config,
    ) {}

    public function handle(ServerRequestInterface $request, Page $page, string $ext): ?RouteResult
    {
        $contentType = $this->config->allowedExtensions[$ext];

        return new RouteSuccess(
            action: $this->action(...),
            method: $request->getMethod(),
            vars: [
                'file' => $page->variant($ext)->physicalPath,
                'contentType' => $contentType,
            ],
        );
    }

    public function action(ServerRequestInterface $request, PhysicalPath $file, string $contentType): ResponseInterface
    {
        return $this->builder->handleCacheableFileRequest($request, (string)$file, function () use ($file, $contentType) {
            $stream = $this->streamFactory->createStreamFromFile((string)$file);
            $stream->rewind();
            return $this->builder->ok($stream, $contentType);
        });
    }
}
