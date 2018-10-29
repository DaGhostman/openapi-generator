<?php declare(strict_types=1);
namespace OpenAPI\Interfaces;

use OpenAPI\Spec\Entities\Document;

interface ParserInterface
{
    public function parse(string $file): Document;
}
