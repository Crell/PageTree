<?php

declare(strict_types=1);

namespace Crell\PageTree\PageTree\Parser;

use Crell\PageTree\PageTree\LogicalPath;
use Crell\PageTree\PageTree\ParsedFrontmatter;

interface FileParser
{
    /**
     * @return array<string>
     *     A list of supported file extensions.
     */
    public array $supportedExtensions { get; }

    public function map(\SplFileInfo $fileInfo, LogicalPath $parentLogicalPath, string $basename): ParsedFrontmatter|FileParserError;
}
