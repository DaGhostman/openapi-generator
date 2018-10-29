<?php

use OpenAPI\Readers\JsonReader;
use OpenAPI\Spec\V3\Parser;
require_once __DIR__ . '/vendor/autoload.php';

$reader = new JsonReader;
$parser = new Parser($reader);

var_dump($parser->parse(__DIR__ . '/swagger.json'));
