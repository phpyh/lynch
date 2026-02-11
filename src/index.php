<?php

declare(strict_types=1);

namespace PHPyh\Lynch;

final readonly class Article
{
    public function __construct(
        public string $title,
        public string $description,
        public \DateTimeImmutable $publishedAt = new \DateTimeImmutable(),
    ) {}
}

var_dump([10 => 'awd']);
