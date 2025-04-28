<?php

return [
    'Database' => [
        'Database' => [
            'Database' => [
                [
                    'label'      => 'Produk',
                    'route'      => 'product.index',
                    'routes'     => ['product.index', 'product.create', 'product.read', 'product.update'],
                    'permission' => 'product: menu',
                    'icon'       => ''
                ],
                [
                    'label'      => 'Akun Produk',
                    'route'      => 'akun-product.index',
                    'routes'     => ['akun-product.index', 'akun-product.create', 'akun-product.read', 'akun-product.update'],
                    'permission' => 'akun-product: menu',
                    'icon'       => ''
                ],
            ]
        ]
    ],
    'Pengaturan' => [
        'Pengaturan' => [
            'Akun' => [
                'label'      => 'Akun',
                'route'      => 'akun.index',
                'routes'     => ['akun.index', 'akun.create', 'akun.show', 'akun.edit'],
                'permission' => 'akun: menu',
                'icon'       => 'users'
            ],
            'Peran' => [
                'label'      => 'Peran',
                'route'      => 'peran.index',
                'routes'     => ['peran.index', 'peran.create', 'peran.show', 'peran.edit'],
                'permission' => 'peran: menu',
                'icon'       => 'key'
            ],
            'Perizinan' => [
                'label'      => 'Perizinan',
                'route'      => 'perizinan.index',
                'routes'     => ['perizinan.index', 'perizinan.create', 'perizinan.show', 'perizinan.edit'],
                'permission' => 'perizinan: menu',
                'icon'       => 'finger-print'
            ]
        ]
    ],
];
