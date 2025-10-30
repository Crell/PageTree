<?php

declare(strict_types=1);

namespace Crell\PageTree\PageTree\Router;

use Crell\PageTree\PageTree\Page;
use Crell\PageTree\Router\RouteResult;
use Psr\Http\Message\ServerRequestInterface;

interface SupportsTrailingPath extends PageHandler
{
    public function handle(ServerRequestInterface $request, Page $page, string $ext, array $trailing = []): ?RouteResult;
}
