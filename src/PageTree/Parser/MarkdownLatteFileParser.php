<?php

declare(strict_types=1);

namespace Crell\PageTree\PageTree\Parser;

use Crell\PageTree\MarkdownDeserializer\MarkdownError;
use Crell\PageTree\MarkdownDeserializer\MarkdownPageLoader;
use Crell\PageTree\PageTree\LogicalPath;
use Crell\PageTree\PageTree\ParsedFrontmatter;

class MarkdownLatteFileParser implements FileParser
{
    public private(set) array $supportedExtensions = ['md'];

    public function __construct(
        private MarkdownPageLoader $loader,
    ) {}

    public function map(\SplFileInfo $fileInfo, LogicalPath $parentLogicalPath, string $basename): ParsedFrontmatter|FileParserError
    {
        $page = $this->loader->load($fileInfo->getPathname());

        if ($page === MarkdownError::FileNotFound) {
            return FileParserError::FileNotSupported;
        }

        return $page;
    }
}
