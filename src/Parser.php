<?php

declare(strict_types=1);

namespace PHPyh\Lynch;

use Feolius\Hell2Shape\Lexer\Token;
use Feolius\Hell2Shape\Parser\Node\AbstractNode;

final class Parser
{
    /**
     * @param list<Token> $tokens
     */
    public static function parse(array $tokens): AbstractNode
    {
        return new self($tokens)->doParse();
    }

    /**
     * @param list<Token> $tokens
     * @param non-negative-int $position
     */
    private function __construct(
        private array $tokens,
        private int $position = 0,
    ) {}

    private function doParse(): AbstractNode
    {
        throw new \LogicException('TODO');
    }
}

Parser::parse([]);
