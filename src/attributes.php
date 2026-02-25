<?php

declare(strict_types=1);

#[Attribute(Attribute::TARGET_ALL)]
final readonly class Attr
{

}

#[ORM\Entity]
#[Attr]
final class X
{
    public function __construct(
        #[ORM\Column]
        public private(set) string $name,
    ) {}
}

X::class;
X::$name::name;

var_dump(
    array_map(
        static fn (ReflectionAttribute $attribute) => $attribute->newInstance(),
        new ReflectionClass(X::class)->getAttributes(Attr::class),
    )
);
