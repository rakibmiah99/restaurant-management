<?php
$actions = [
    'create' => 'إنشاء',
    'update' => 'تحديث',
    'delete' => 'حذف',
    'view' => 'عرض',
    'export' => 'تصدير',
    'change_status' => 'تغيير الحالة'
];

return [
    'company' => [
        'name' => 'شركة',
        'actions' => $actions
    ],
    'meal_price' => [
        'name' => 'سعر الوجبة',
        'actions' => $actions
    ],
    'hotel' => [
        'name' => 'فندق',
        'actions' => $actions
    ],
    'hall' => [
        'name' => 'قاعة',
        'actions' => $actions
    ],
    'order' => [
        'name' => 'طلب',
        'actions' => array_merge($actions, [
            'monitoring' => 'مراقبة',
            'complete_order' => 'إكمال الطلب',
            'modify_guest' => 'تعديل الضيف',
            'show_qr' => 'عرض QR'
        ])
    ],
    'invoice' => [
        'name' => 'فاتورة',
        'actions' => $actions
    ],

    'report' => [
        'name' => 'تقرير',
        'actions' => [
            'hall' => 'قاعة',
            'hotel' => 'فندق',
            'kitchen' => 'مطبخ',
            'revenue' => 'إيرادات',
            'order' => 'طلب',
            'invoice' => 'فاتورة',
            'packaging' => 'تغليف',
        ]
    ],

    'settings' => [
        'name' => 'الإعدادات',
        'actions' => [
            'update' => $actions['update']
        ]
    ],

    'role' => [
        'name' => 'الأدوار',
        'actions' => collect($actions)->only(['create', 'view', 'update', 'delete'])->toArray()
    ],

    'user' => [
        'name' => 'المستخدمون',
        'actions' => collect($actions)->except(['change_status'])->toArray()
    ],
];

