<?php

declare(strict_types=1);

namespace Crell\PageTree\PageTree\Parser;

use Crell\PageTree\Config\StaticRoutes;
use Crell\PageTree\PageTree\BasicParsedFrontmatter;
use Crell\PageTree\PageTree\LogicalPath;
use Crell\PageTree\PageTree\ParsedFrontmatter;

class StaticFileParser implements FileParser
{
    public array $supportedExtensions {
        // Ignore HTML files, as those get their own parser.
        get => array_diff(array_keys($this->config->allowedExtensions), ['html']);
    }

    public function __construct(
        private readonly StaticRoutes $config,
    ) {}

    public function map(\SplFileInfo $fileInfo, LogicalPath $parentLogicalPath, string $basename): ParsedFrontmatter|FileParserError
    {
        // Static files have no frontmatter to parse.
        return new BasicParsedFrontmatter(
            title: ucfirst($basename),
            hidden: true,
        );
    }
}
