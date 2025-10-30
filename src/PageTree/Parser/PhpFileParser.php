<?php

declare(strict_types=1);

namespace Crell\PageTree\PageTree\Parser;

use Crell\PageTree\ClassFinder;
use Crell\PageTree\PageTree\Attributes\PageRoute;
use Crell\PageTree\PageTree\LogicalPath;
use Crell\PageTree\PageTree\ParsedFrontmatter;
use Crell\PageTree\PageTree\PhysicalPath;

class PhpFileParser implements FileParser
{
    public private(set) array $supportedExtensions = ['php'];

    public function __construct(
        private readonly ClassFinder $finder = new ClassFinder(),
    ) {}

    public function map(\SplFileInfo $fileInfo, LogicalPath $parentLogicalPath, string $basename): ParsedFrontmatter
    {
        $physicalPath = $fileInfo->getPathname();

        return $this->extractFrontMatter(PhysicalPath::create($physicalPath));
    }

    private function extractFrontMatter(PhysicalPath $physicalPath): PageRoute
    {
        require_once $physicalPath;
        $class = $this->finder->getClass((string)$physicalPath);

        if (!$class) {
            return new PageRoute();
        }

        $attribs = array_map(fn(\ReflectionAttribute $a) => $a->newInstance(),  (new \ReflectionClass($class))->getAttributes(PageRoute::class));

        return $attribs[0] ?? new PageRoute(title: $class);
    }
}
