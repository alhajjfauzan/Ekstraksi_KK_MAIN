<?php

return [
    /*
     * Your API path. By default, all routes starting with this path will be added to the docs.
     * If you need to change this behavior, you can add your custom routes resolver to `add_routes` config.
     */
    'api_path' => 'api',

    /*
     * Your API domain. By default, app domain is used. This is also a part of the default API routes
     * matching resolution algorithm.
     */
    'api_domain' => null,

    'info' => [
        /*
         * API version.
         */
        'version' => env('API_VERSION', '1.0.0'),

        /*
         * Description rendered on the home page of the API documentation (`/docs/api`).
         */
        'description' => 'API Documentation untuk Sistem Ekstraksi Kartu Keluarga',

        'title' => 'Ekstraksi KK API Documentation',
    ],

    /*
     * The OpenAPI version. By default, Scramble uses 3.1.0.
     */
    'openapi_version' => '3.1.0',

    'servers' => null,

    'middleware' => [
        'web',
    ],

    'ui' => 'stoplight',

    /*
     * Customize Stoplight Elements UI
     */
    'ui_settings' => [
        // 'hideModels' => true,
    ],
];
