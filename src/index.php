<?php

declare(strict_types=1);

namespace PHPyh\Lynch;

use Feolius\Hell2Shape\Lexer\Lexer;
use Feolius\Hell2Shape\Parser\Parser;
use function Typhoon\Type\stringify;

require_once __DIR__.'/../vendor/autoload.php';

ob_start();

$object = new \stdClass();
$object->{''} = 123;

var_dump([
    'a' => [$object, new \ArrayObject()],
    'b' => STDOUT,
    'c' => [10 => true, 0.5, 'STRING'],
]);

$varDump = ob_get_clean();

$tokens = new Lexer()->tokenize($varDump);
$node = new Parser()->parse($tokens);

$type = $node->accept(new ToTyphoonType());

echo stringify($type);
