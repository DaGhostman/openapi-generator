<?php declare(strict_types=1);
namespace OpenAPI\Readers;

use OpenAPI\Interfaces\ReaderInterface;

class JsonReader implements ReaderInterface
{
    public function parseFile(string $filename): array
    {
        return $this->parseString(file_get_contents($filename));
    }

    public function parseString(string $string): array
    {
        return json_decode($string, true);
    }
}
