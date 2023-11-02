<?php

return [
    'name' => 'onTour App',
    'manifest' => [
        'name' => env('APP_NAME', 'onTour App'),
        'short_name' => 'onTour',
        'start_url' => 'https://app.ontour.org',
        'background_color' => '#ffffff',
        'theme_color' => '#ffffff',
        'display' => 'standalone',
        'orientation' => 'portrait-primary',
        'status_bar' => 'black',
        'icons' => [
            '72x72' => [
                'path' => '/images/icons/icon-72x72.png',
                'sizes' => '72x72',
                'purpose' => 'any maskable'
            ],
            '96x96' => [
                'path' => '/images/icons/icon-96x96.png',
                'sizes' => '96x96',
                'purpose' => 'any maskable'
            ],
            '128x128' => [
                'path' => '/images/icons/icon-128x128.png',
                'sizes' => '128x128',
                'purpose' => 'any maskable'
            ],
            '144x144' => [
                'path' => '/images/icons/icon-144x144.png',
                'sizes' => '144x144',
                'purpose' => 'any maskable'
            ],
            '152x152' => [
                'path' => '/images/icons/icon-152x152.png',
                'sizes' => '152x152',
                'purpose' => 'any maskable'
            ],
            '192x192' => [
                'path' => '/images/icons/icon-192x192.png',
                'sizes' => '192x192',
                'purpose' => 'any maskable'
            ],
            '384x384' => [
                'path' => '/images/icons/icon-384x384.png',
                'sizes' => '384x384',
                'purpose' => 'any maskable'
            ],
            '512x512' => [
                'path' => '/images/icons/icon-512x512.png',
                'sizes' => '512x512',
                'purpose' => 'any maskable'
            ],
        ],
        'splash' => [
            '640x1136' => '/images/icons/splash-640x1136.png',
            '750x1334' => '/images/icons/splash-750x1334.png',
            '828x1792' => '/images/icons/splash-828x1792.png',
            '1125x2436' => '/images/icons/splash-1125x2436.png',
            '1242x2208' => '/images/icons/splash-1242x2208.png',
            '1242x2688' => '/images/icons/splash-1242x2688.png',
            '1536x2048' => '/images/icons/splash-1536x2048.png',
            '1668x2224' => '/images/icons/splash-1668x2224.png',
            '1668x2388' => '/images/icons/splash-1668x2388.png',
            '2048x2732' => '/images/icons/splash-2048x2732.png',
        ],
        'shortcuts' => [
            [
                'name' => 'Login',
                'description' => 'Meld dich an',
                'url' => '/login',
                'icons' => [
                    "src" => "/images/icons/icon-96x96.png",
                    "purpose" => "any maskable"
                ]
            ]
        ],
        'custom' => []
    ]
];
