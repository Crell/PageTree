<?php

declare(strict_types=1);

namespace Crell\PageTree\PageTree;

use Crell\PageTree\PageTree\Page;
use Crell\PageTree\PageTree\PhysicalPath;
use DateTimeImmutable;

class MockPage implements Page
{
    /**
     * @var array<string, mixed>
     */
    private array $values;

    public string $title {
        get => $this->values[__PROPERTY__] ?? '';
    }
    public string $summary {
        get => $this->values[__PROPERTY__] ?? '';
    }
    public array $tags {
        get => $this->values[__PROPERTY__] ?? [];
    }
    public bool $hidden {
        get => $this->values[__PROPERTY__] ?? false;
    }
    public bool $routable {
        get => $this->values[__PROPERTY__] ?? true;
    }
    public DateTimeImmutable $publishDate {
        get => $this->values[__PROPERTY__] ?? new DateTimeImmutable();
    }
    public DateTimeImmutable $lastModifiedDate {
        get => $this->values[__PROPERTY__] ?? new DateTimeImmutable();
    }
    public array $other {
        get => $this->values[__PROPERTY__] ?? [];
    }
    public string $path {
        get => $this->values[__PROPERTY__] ?? '';
    }
    public PhysicalPath $physicalPath {
        get => $this->values[__PROPERTY__] ?? throw new \InvalidArgumentException('No physical path defined.');
    }
    public string $folder {
        get => $this->values[__PROPERTY__] ?? '';
    }

    /**
     * @param mixed ...$values
     */
    public function __construct(...$values)
    {
        $this->values = $values;
    }

    /**
     * @return array<string, MockPage>
     */
    public function variants(): array
    {
        return [$this->physicalPath->ext => $this];
    }

    public function variant(string $ext): ?Page
    {
        return $this;
    }

    /**
     * @return string[]
     */
    public function getTrailingPath(string $fullPath): array
    {
        // @todo Incomplete.
        return [];
    }
}