<?php
return [
    'dashboard'           => [
        'label'      => 'Dashboard',
        'icon'       => 'fa fa-tachometer',
        'controller' => 'Admin\DashboardController',
        'methods'    => ['index'],
    ],
    'user-administration' => [
        'label'      => 'User Administration',
        'icon'       => 'fa fa-user',
        'controller' => '#',
        'child'      => [
            'role' => [
                'label'      => 'Role',
                'controller' => 'Admin\RoleController',
                'methods'    => [
                    'index', 'create', 'update', 'delete',
                ],
            ],
            'user' => [
                'label'      => 'User',
                'controller' => 'Admin\UserController',
                'methods'    => [
                    'index', 'create', 'update', 'delete',
                ],
            ],
        ],
    ],
    'media-library'       => [
        'label'      => 'Media Library',
        'icon'       => 'fa fa-file-image-o',
        'controller' => 'Admin\MediaLibraryController',
        'methods'    => ['index'],
    ],
    'setting'             => [
        'label'      => 'Setting',
        'icon'       => 'fa fa-plug',
        'controller' => '#',
        'child'      => [

            'setting-meta'    => [
                'label'      => 'Meta',
                'controller' => 'Admin\SettingMetaController',
                'methods'    => [
                    'index',
                ],
            ],
            'setting-general' => [
                'label'      => 'General',
                'controller' => 'Admin\SettingGeneralController',
                'methods'    => [
                    'index',
                ],
            ],
        ],
    ],
    'developer'           => [
        'label'      => 'Developer Administration',
        'controller' => '#',
        'icon'       => 'fa fa-code',
        'child'      => [
            'example' => [
                'label'      => 'Crud Example',
                'controller' => 'Admin\CrudController',
                'methods'    => [
                    'index', 'create', 'update', 'delete', 'publishdraft',
                ],
            ],
            'scaffolding' => [
                'label'      => 'Scaffolding Example',
                'controller' => 'Admin\ScaffoldingController',
                'methods'    => [
                    'index', 'create', 'update', 'delete', 'publishdraft',
                ],
            ],
            'dimsav'  => [
                'label'      => 'Multi Language Example',
                'controller' => 'Admin\DimsavController',
                'methods'    => [
                    'index', 'create', 'update', 'delete', 'publishdraft',
                ],
            ],
            'static'  => [
                'label'      => 'Static Example',
                'controller' => 'Admin\StaticController',
                'methods'    => [
                    'index',
                ],
            ],
        ],
    ],
];
