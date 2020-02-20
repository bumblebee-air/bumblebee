<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Custom Elasticsearch Client Configuration
    |--------------------------------------------------------------------------
    |
    | This array will be passed to the Elasticsearch client.
    | See configuration options here:
    |
    | http://www.elasticsearch.org/guide/en/elasticsearch/client/php-api/current/_configuration.html
    */

    'config' => [
        'hosts'     => array([
            'host'       => env('ELASTICSEARCH_HOST', 'localhost'),
            'port'       => env('ELASTICSEARCH_PORT', 9200),
            'scheme'     => env('ELASTICSEARCH_SCHEME', null),
            'user'       => env('ELASTICSEARCH_USER', null),
            'pass'       => env('ELASTICSEARCH_PASS', null),
        ]),
        'retries'   => 1,
    ],

    'mapping' => [
        'keywords'  => 'Keyword'
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Index Name
    |--------------------------------------------------------------------------
    |
    | This is the index name that Elasticquent will use for all
    | Elasticquent models.
    */

    'default_index' => '',

);
