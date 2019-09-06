<?php

use OpenAPI\Readers\JsonReader;
use OpenAPI\Spec\V3\Parser;
use OpenAPI\Spec\V3\Serializer;
require_once __DIR__ . '/vendor/autoload.php';

$reader = new JsonReader;
$parser = new Parser($reader);
// $serializer = new Serializer(
//     $parser->parse(__DIR__ . '/swagger.json')
// );

file_put_contents(__DIR__ . '/temp.json', json_encode(Serializer::serialize($parser->parse(__DIR__ . '/swagger.json')), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
