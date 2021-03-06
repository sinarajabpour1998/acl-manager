<?php

return [

    // set custom permission names for menus and routes
    // all permissions (except for menu) must be start with [permission:] keyword
    'permissions' => [
        'main' => 'permission:acl-manager',
        'users' => 'permission:acl-manager-users',
        'roles' => 'permission:acl-manager-roles',
        'permissions' => 'permission:acl-manager-permissions',
        'menu' => [
            'main' => 'acl-manager',
            'users' => 'acl-manager-users',
            'roles' => 'acl-manager-roles',
            'permissions' => 'acl-manager-permissions'
        ]
    ],
    'encryption' => [
        'mobile_encryption' => true,
        'email_encryption' => true,
        'city_encryption' => true,
        'postal_code_encryption' => true,
        'address_encryption' => true,
        'organization_encryption' => true
    ]

];
