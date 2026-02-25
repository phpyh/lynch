<?php

use Laminas\Http\Request;
use Laminas\Http\Response;
use LaminasAttributeController\Validation\QueryParam;

require_once __DIR__.'/../vendor/autoload.php';

final readonly class Controller
{
    public function action(#[QueryParam] #[QueryParam] int $request): Response
    {
        return new Response();
    }
}

dd(new ReflectionFunction(new Controller()->action(...))->getParameters()[0]->getAttributes(QueryParam::class)[0]->newInstance());
