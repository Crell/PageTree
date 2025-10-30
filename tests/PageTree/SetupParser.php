<?php

declare(strict_types=1);

namespace Crell\PageTree\PageTree;

use Crell\PageTree\Config\StaticRoutes;
use Crell\PageTree\MarkdownDeserializer\MarkdownPageLoader;
use Crell\PageTree\PageTree\Parser\HtmlFileParser;
use Crell\PageTree\PageTree\Parser\LatteFileParser;
use Crell\PageTree\PageTree\Parser\MarkdownLatteFileParser;
use Crell\PageTree\PageTree\Parser\MultiplexedFileParser;
use Crell\PageTree\PageTree\Parser\Parser;
use Crell\PageTree\PageTree\Parser\PhpFileParser;
use Crell\PageTree\PageTree\Parser\StaticFileParser;
use PHPUnit\Framework\Attributes\Before;

trait SetupParser
{
    use SetupRepo;

    private Parser $parser;

    #[Before(5)]
    public function setupParser(): void
    {
        $fileParser = new MultiplexedFileParser();
        $fileParser->addParser(new HtmlFileParser());
        $fileParser->addParser(new StaticFileParser(new StaticRoutes()));
        $fileParser->addParser(new PhpFileParser());
        $fileParser->addParser(new LatteFileParser());
        $fileParser->addParser(new MarkdownLatteFileParser(new MarkdownPageLoader()));

        $this->parser = new Parser($this->repo, $fileParser);
    }
}
