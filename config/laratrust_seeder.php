<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'superadministrator' => [
            'users' => 'c,r,u,d,t,s',
            'roles' => 'c,r,u,d,t,s',
            'settings' => 'c,r,u,d,t,s',
            'countries' => 'c,r,u,d,t,s',
            'categories' => 'c,r,u,d,t,s',
            'products' => 'c,r,u,d,t,s',
            'orders' => 'c,r,u,d,t,s',
            'reports' => 'c,r,u,d,t,s',
            'orders_report' => 'c,r,u,d,t,s',
            'notifications' => 'c,r,u,d,t,s',
            'shipping_rates' => 'c,r,u,d,t,s',
            'withdrawals' => 'c,r,u,d,t,s',
            'notes' => 'c,r,u,d,t,s',
            'messages' => 'c,r,u,d,t,s',
            'slides' => 'c,r,u,d,t,s',
            'orders_notes' => 'c,r,u,d,t,s',
            'logs' => 'c,r,u,d,t,s',
            'bonus' => 'c,r,u,d,t,s',
            'stock_management' => 'c,r,u,d,t,s',
            'brands' => 'c,r,u,d,t,s',
            'attributes' => 'c,r,u,d,t,s',
            'variations' => 'c,r,u,d,t,s',
            'warehouses' => 'c,r,u,d,t,s',
            'website_setting' => 'c,r,u,d,t,s',
            'states' => 'c,r,u,d,t,s',
            'cities' => 'c,r,u,d,t,s',
            'shipping_method' => 'c,r,u,d,t,s',
            'medias' => 'c,r,u,d,t,s',
            'accounts' => 'c,r,u,d,t,s',
            'taxes' => 'c,r,u,d,t,s',
            'entries' => 'c,r,u,d,t,s',
            'purchases' => 'c,r,u,d,t,s',
            'income_statement' => 'c,r,u,d,t,s',
            'sales' => 'c,r,u,d,t,s',
            'branches' => 'c,r,u,d,t,s',
            'credit_management' => 'c,r,u,d,t,s',
            'stages' => 'c,r,u,d,t,s',
            'previews' => 'c,r,u,d,t,s',
            'previews_clients' => 'c,r,u,d,t,s',
            'previews_score' => 'c,r,u,d,t,s',
            'assets' => 'c,r,u,d,t,s',
            'balance_statement' => 'c,r,u,d,t,s',
            'crm' => 'c,r,u,d,t,s',
            'vendor_products' => 'c,r,u,d,t,s',
            'trial_balance' => 'c,r,u,d,t,s',
            'add_stock' => 'c,r,u,d,t,s',
            'stock_lists' => 'c,r,u,d,t,s',
            'stock_inventory' => 'c,r,u,d,t,s',
            'stock_transfers' => 'c,r,u,d,t,s',
            'stock_shortages' => 'c,r,u,d,t,s',
            'vendor_orders' => 'c,r,u,d,t,s',
            'payments' => 'c,r,u,d,t,s',
            'running_orders' => 'c,r,u,d,t,s',
            'coupons' => 'c,r,u,d,t,s',
        ],
        'administrator' => [],
        'vendor' => [],
        'affiliate' => [],
        'user' => [],
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
        't' => 'trash',
        's' => 'restore',
    ]
];
