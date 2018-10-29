<?php declare(strict_types=1);
namespace OpenAPI\Interfaces;

interface ReaderInterface
{
    public function parseFile(string $filename): array;
    public function parseString(string $string): array;
}
