<?php

declare(strict_types=1);

namespace PHPyh\Lynch;

use Feolius\Hell2Shape\Parser\Node\AnonymousObjectNode;
use Feolius\Hell2Shape\Parser\Node\BoolNode;
use Feolius\Hell2Shape\Parser\Node\FloatNode;
use Feolius\Hell2Shape\Parser\Node\HashmapItemNode;
use Feolius\Hell2Shape\Parser\Node\HashmapNode;
use Feolius\Hell2Shape\Parser\Node\IntNode;
use Feolius\Hell2Shape\Parser\Node\ListItemNode;
use Feolius\Hell2Shape\Parser\Node\ListNode;
use Feolius\Hell2Shape\Parser\Node\NodeVisitorInterface;
use Feolius\Hell2Shape\Parser\Node\NullNode;
use Feolius\Hell2Shape\Parser\Node\ObjectNode;
use Feolius\Hell2Shape\Parser\Node\ResourceNode;
use Feolius\Hell2Shape\Parser\Node\StdObjectItemNode;
use Feolius\Hell2Shape\Parser\Node\StdObjectNode;
use Feolius\Hell2Shape\Parser\Node\StringNode;
use Typhoon\Type;

/**
 * @implements NodeVisitorInterface<Type>
 */
final readonly class ToTyphoonType implements NodeVisitorInterface
{
    public function visitBool(BoolNode $node): mixed
    {
        return $node->value ? Type\trueT : Type\falseT;
    }

    public function visitInt(IntNode $node): mixed
    {
        return Type\intT($node->value);
    }

    public function visitFloat(FloatNode $node): mixed
    {
        return Type\floatT($node->value);
    }

    public function visitString(StringNode $node): mixed
    {
        return Type\stringT($node->value);
    }

    public function visitNull(NullNode $node): mixed
    {
        return Type\nullT;
    }

    public function visitResource(ResourceNode $node): mixed
    {
        return Type\resourceT;
    }

    public function visitObject(ObjectNode $node): mixed
    {
        return Type\objectT($node->className); // @phpstan-ignore argument.type, argument.templateType
    }

    public function visitAnonymousObject(AnonymousObjectNode $node): mixed
    {
        return Type\objectT;
    }

    public function visitHashmap(HashmapNode $node): mixed
    {
        return Type\arrayShapeT(
            array_combine(
                array_map(
                    fn (HashmapItemNode $item) => $item->key->value,
                    $node->items,
                ),
                array_map(
                    fn (HashmapItemNode $item) => $item->value->accept($this),
                    $node->items,
                )
            )
        );
    }

    public function visitHashmapItem(HashmapItemNode $node): mixed
    {
        throw new \LogicException();
    }

    public function visitStdObject(StdObjectNode $node): mixed
    {
        return Type\objectShapeT(
            array_combine( // @phpstan-ignore argument.type
                array_map(
                    fn (StdObjectItemNode $item) => $item->key->value,
                    $node->items,
                ),
                array_map(
                    fn (StdObjectItemNode $item) => $item->value->accept($this),
                    $node->items,
                )
            )
        );
    }

    public function visitStdObjectItem(StdObjectItemNode $node): mixed
    {
        throw new \LogicException();
    }

    public function visitList(ListNode $node): mixed
    {
        return Type\listShapeT(
            array_map(
                fn (ListItemNode $item) => $item->value->accept($this),
                $node->items,
            )
        );
    }
}
