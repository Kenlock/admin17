<?php
return [
    'dashboard'           => [
        'label'      => 'Dashboard',
        'controller' => 'Admin\DashboardController',
        'methods'    => ['index'],
    ],    
    'user-administration' => [
        'label'      => 'User Administration',
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
        'controller' => 'Admin\MediaLibraryController',
        'methods'    => ['index'],
    ],
    'setting'             => [
        'label'      => 'Setting',
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
        'child'      => [
            'example' => [
                'label'      => 'Crud Example',
                'controller' => 'Admin\CrudController',
                'methods'    => [
                    'index', 'create', 'update', 'delete', 'publishdraft',
                ],
            ],
        ],
    ],
];
