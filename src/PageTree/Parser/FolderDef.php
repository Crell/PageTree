<?php

declare(strict_types=1);

namespace Crell\PageTree\PageTree\Parser;

use Crell\PageTree\PageTree\BasicParsedFrontmatter;
use Crell\PageTree\PageTree\SortOrder;

readonly class FolderDef
{
    public function __construct(
        public SortOrder $order = SortOrder::Asc,
        public bool $flatten = false,
        public bool $hidden = false,
        public BasicParsedFrontmatter $defaults = new BasicParsedFrontmatter(),
    ) {}
}
