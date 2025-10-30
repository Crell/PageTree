<?php

declare(strict_types=1);

namespace Crell\PageTree\PageTree\Router;

use Crell\PageTree\PageTree\Page;
use Crell\PageTree\Router\RouteResult;
use Psr\Http\Message\ServerRequestInterface;

interface PageHandler
{
    public array $supportedMethods { get; }

    public array $supportedExtensions { get; }

    public function handle(ServerRequestInterface $request, Page $page, string $ext): ?RouteResult;
}
