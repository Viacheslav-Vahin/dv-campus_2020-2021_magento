<?php
return [
    'backend' => [
        'frontName' => 'admin'
    ],
    'queue' => [
        'consumers_wait_for_messages' => 1
    ],
    'crypt' => [
        'key' => '21de91459b1c8ce5e9df83f0099f22bc'
    ],
    'db' => [
        'table_prefix' => 'm2_',
        'connection' => [
            'default' => [
                'host' => 'mysql',
                'dbname' => 'viacheslav_vahin_build_loc',
                'username' => 'viacheslav_vahin_build_loc',
                'password' => '^TF#FRUiKNLFOlkdas',
                'model' => 'mysql4',
                'engine' => 'innodb',
                'initStatements' => 'SET NAMES utf8;',
                'active' => '1',
                'driver_options' => [
                    1014 => false
                ]
            ]
        ]
    ],
    'resource' => [
        'default_setup' => [
            'connection' => 'default'
        ]
    ],
    'x-frame-options' => 'SAMEORIGIN',
    'MAGE_MODE' => 'production',
    'session' => [
        'save' => 'redis',
        'redis' => [
            'host' => 'redis',
            'port' => '6379',
            'password' => '',
            'timeout' => '2.5',
            'persistent_identifier' => '',
            'database' => '2',
            'compression_threshold' => '2048',
            'compression_library' => 'gzip',
            'log_level' => '4',
            'max_concurrency' => '6',
            'break_after_frontend' => '5',
            'break_after_adminhtml' => '30',
            'first_lifetime' => '600',
            'bot_first_lifetime' => '60',
            'bot_lifetime' => '7200',
            'disable_locking' => '1',
            'min_lifetime' => '60',
            'max_lifetime' => '2592000'
        ]
    ],
    'cache' => [
        'frontend' => [
            'default' => [
                'id_prefix' => '69d_'
            ],
            'page_cache' => [
                'id_prefix' => '69d_'
            ]
        ],
        'allow_parallel_generation' => false
    ],
    'lock' => [
        'provider' => 'db',
        'config' => [
            'prefix' => null
        ]
    ],
    'cache_types' => [
        'config' => 1,
        'layout' => 1,
        'block_html' => 1,
        'collections' => 1,
        'reflection' => 1,
        'db_ddl' => 1,
        'compiled_config' => 1,
        'eav' => 1,
        'customer_notification' => 1,
        'config_integration' => 1,
        'config_integration_api' => 1,
        'full_page' => 1,
        'config_webservice' => 1,
        'translate' => 1,
        'vertex' => 1
    ],
    'downloadable_domains' => [
        'viacheslav-vahin-develop.loc'
    ],
    'install' => [
        'date' => 'Thu, 15 Oct 2020 11:13:54 +0000'
    ],
    'system' => [
        'default' => [
            'web' => [
                'unsecure' => [
                    'base_url' => 'https://viacheslav-vahin-develop.loc/',
                    'base_link_url' => '{{unsecure_base_url}}',
                    'base_static_url' => 'https://viacheslav-vahin-develop.loc/static/',
                    'base_media_url' => 'https://viacheslav-vahin-develop.loc/media/'
                ],
                'secure' => [
                    'base_url' => 'https://viacheslav-vahin-develop.loc/',
                    'base_link_url' => '{{secure_base_url}}',
                    'base_static_url' => 'https://viacheslav-vahin-develop.loc/static/',
                    'base_media_url' => 'https://viacheslav-vahin-develop.loc/media/'
                ]
            ]
        ],
        'websites' => [
            'base' => [
                'design' => [
                    'theme' => [
                        'theme_id' => 4
                    ]
                ]
            ],
            'additional_website' => [
                'web' => [
                    'unsecure' => [
                        'base_url' => 'https://viacheslav-vahin-additional-develop.loc/',
                        'base_link_url' => 'https://viacheslav-vahin-additional-develop.loc/',
                        'base_static_url' => 'https://viacheslav-vahin-additional-develop.loc/static/',
                        'base_media_url' => 'https://viacheslav-vahin-additional-develop.loc/media/'
                    ],
                    'secure' => [
                        'base_url' => 'https://viacheslav-vahin-additional-develop.loc/',
                        'base_link_url' => 'https://viacheslav-vahin-additional-develop.loc/',
                        'base_static_url' => 'https://viacheslav-vahin-additional-develop.loc/static/',
                        'base_media_url' => 'https://viacheslav-vahin-additional-develop.loc/media/'
                    ]
                ]
            ]
        ]
    ]
];
