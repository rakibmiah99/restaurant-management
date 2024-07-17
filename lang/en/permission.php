<?php
    $actions = [
        'create' => 'Create',
        'update' => 'Update',
        'delete' => 'Delete',
        'view' => 'view',
        'export' => 'Export',
        'change_status' => 'Change Status'
    ];

return [
    'company' => [
        'name' => 'Company',
        'actions' => $actions
    ],
    'meal_price' => [
        'name' => 'Meal Price',
        'actions' => $actions
    ],
    'hotel' => [
        'name' => 'Hotel',
        'actions' => $actions
    ],
    'hall' => [
        'name' => 'Hall',
        'actions' => $actions
    ],
    'order' => [
        'name' => 'Order',
        'actions' => array_merge($actions, [
            'monitoring' => 'Monitoring',
            'complete_order' => 'Complete Order',
            'modify_guest' => 'Modify Guest',
            'show_qr' => 'Show QR'
        ])
    ],
    'invoice' => [
        'name' => 'Invoice',
        'actions' => $actions
    ],

    'report' => [
        'name' => 'Report',
        'actions' => [
            'hall' => 'Hall',
            'hotel' => 'Hotel',
            'kitchen' => 'Kitchen',
            'revenue' => 'Revenue',
            'order' => 'Order',
            'invoice' => 'Invoice',
            'packaging' => 'Packaging',
        ]
    ],

    'settings' => [
        'name' => 'Settings',
        'actions' => [
            'update' => $actions['update']
        ]
    ],

    'role' => [
        'name' => 'Roles',
        'actions' => collect($actions)->only(['create', 'view', 'update', 'delete'])->toArray()
    ],

    'user' => [
        'name' => 'Users',
        'actions' => collect($actions)->except(['change_status'])->toArray()
    ],
];
