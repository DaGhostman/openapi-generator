<?php

return [
    [
        'name' => 'test',
        'pattern' => '/products',
        'middleware' => [],
        'methods' => ['GET', 'POST'],
        'deprecated' => false,
        'api' => [
            'summary' => 'Products summary', // @todo: fetch from code comment
            'description' => 'Products Description', // @todo: fetch from code comments
            'tags' => [
                'products' =>  'A simple tag for products'
            ],
            'methods' => [
                'GET' => [
                    'description' => 'Some GET description',
                    'schema' => 'ProductList',
                    'tags' => ['products'],
                    'headers' => [
                        'X-RateLimit-Request' => [
                            'description' => 'Number of requests remaining',
                            'type' => 'integer'
                        ]
                    ]
                ],
                'POST' => [
                    'description' => 'Some POST description',
                    'schema' => 'ProductList',
                    'tags' => ['products'],
                    'headers' => [
                        'Link' => [
                            'description' => 'Location where the new product could be found',
                            'type' => 'integer'
                        ]
                    ]
                ]
            ]
        ]
    ]
];