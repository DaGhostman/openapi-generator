<?php declare(stricty_types=1);
namespace OpenAPI\Interfaces;

interface ParserInterface
{
    public function parse(string $file): array;
}
