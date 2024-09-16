<?php

return [
    'invoices' => [
        'title' => 'الفواتير',
        'group' => 'المدفوعات',
        'single' => 'فاتورة',
        'widgets' => [
            'count' => 'إجمالي الفواتير',
            'paid' => 'إجمالي المدفوعات',
            'due' => 'إجمالي المستحقات'
        ],
        'columns' => [
            'uuid' => 'معرّف الفاتورة',
            'name' => 'اسم العميل',
            'phone' => 'رقم الهاتف',
            'address' => 'العنوان',
            'date' => 'تاريخ الفاتورة',
            'due_date' => 'تاريخ الاستحقاق',
            'type' => 'نوع الفاتورة',
            'status' => 'الحالة',
            'currency_id' => 'العملة',
            'items' => 'عناصر الفاتورة',
            'item' => 'عنصر',
            'item_name' => 'اسم العنصر',
            'description' => 'الوصف',
            'qty' => 'الكمية',
            'price' => 'السعر',
            'discount' => 'الخصم',
            'vat' => 'الضريبة على القيمة المضافة',
            'total' => 'المجموع',
            'shipping' => 'الشحن',
            'notes' => 'ملاحظات',
            'account' => 'الحساب',
            'by' => 'بواسطة',
            'from' => 'من',
            'paid' => 'مدفوع',
            'updated_at' => 'تحديث في',
        ],
        'sections' => [
            'from_type' => [
                'title' => 'من النوع',
                'columns' => [
                    'from_type' => 'من النوع',
                    'from' => 'من',
                ],
            ],
            'billed_from' => [
                'title' => 'فاتورة من',
                'columns' => [
                    'for_type' => 'لنوع',
                    'for' => 'لـ',
                ],
            ],
            'customer_data' => [
                'title' => 'بيانات العميل',
                'columns' => [
                    'name' => 'الاسم',
                    'phone' => 'الهاتف',
                    'address' => 'العنوان',
                ],
            ],
            'invoice_data' => [
                'title' => 'بيانات الفاتورة',
                'columns' => [
                    'date' => 'التاريخ',
                    'due_date' => 'تاريخ الاستحقاق',
                    'type' => 'النوع',
                    'status' => 'الحالة',
                    'currency' => 'العملة',
                ],
            ],
            'totals' => [
                'title' => 'الإجماليات'
            ],
        ],
        'filters' => [
            'status' => 'الحالة',
            'type' => 'النوع',
            'due' => [
                'label' => 'تاريخ الاستحقاق',
                'columns' => [
                    'overdue' => 'تأخر',
                    'today' => 'اليوم',
                ]
            ],
            'for' => [
                'label' => 'تصفية حسب لـ',
                'columns' => [
                    'for_type' => 'لنوع',
                    'for_name' => 'لـ الاسم',
                ]
            ],
            'from' => [
                'label' => 'تصفية حسب من',
                'columns' => [
                    'from_type' => 'من النوع',
                    'from_name' => 'من الاسم',
                ]
            ],
        ],
        'actions' => [
            'total' => 'المجموع',
            'paid' => 'مدفوع',
            'amount' => 'المبلغ',
            'view_invoice' => 'عرض الفاتورة',
            'edit_invoice' => 'تعديل الفاتورة',
            'archive_invoice' => 'أرشفة الفاتورة',
            'delete_invoice_forever' => 'حذف الفاتورة نهائيًا',
            'restore_invoice' => 'استعادة الفاتورة',
            'invoices_status' => 'حالة الفواتير',
            'print' => 'طباعة',
            'pay' => [
                'label' => 'دفع الفاتورة',
                'notification' => [
                    'title' => 'الفاتورة مدفوعة',
                    'body' => 'تم دفع الفاتورة بنجاح'
                ]
            ],
            'status' => [
                'title' => 'الحالة',
                'label' => 'تغيير الحالة',
                'tooltip' => 'تغيير حالة الفواتير المحددة',
                'form' => [
                    'model_id' => 'المستخدمون',
                    'model_type' => 'نوع المستخدم',
                ],
                'notification' => [
                    'title' => 'تغيرت الحالة',
                    'body' => 'تم تغيير الحالة بنجاح'
                ]
            ],
        ],
        'logs' => [
            'title' => 'سجلات الفاتورة',
            'single' => 'سجل فاتورة',
            'columns' => [
                'log' => 'السجل',
                'type' => 'النوع',
                'created_at' => 'تاريخ الإنشاء',
            ],
        ],
        'payments' => [
            'title' => 'المدفوعات',
            'single' => 'الدفع',
            'columns' => [
                'amount' => 'المبلغ',
                'created_at' => 'تاريخ الإنشاء',
            ],
        ],
        'view' => [
            'bill_from' => 'فاتورة من',
            'bill_to' => 'فاتورة إلى',
            'invoice' => 'فاتورة',
            'issue_date' => 'تاريخ الإصدار',
            'due_date' => 'تاريخ الاستحقاق',
            'status' => 'الحالة',
            'type' => 'النوع',
            'item' => 'عنصر',
            'total' => 'المجموع',
            'price' => 'السعر',
            'vat' => 'الضريبة على القيمة المضافة',
            'discount' => 'الخصم',
            'qty' => 'الكمية',
            'bank_account' => 'رقم الحساب البنكي',
            'name' => 'الاسم',
            'address' => 'العنوان',
            'branch' => 'الفرع',
            'swift' => 'سويفت',
            'account' => 'الحساب',
            'owner' => 'المالك',
            'iban' => 'IBAN',
            'signature' => 'التوقيع',
            'subtotal' => 'إجمالي الفرعي',
            'tax' => 'الضريبة',
            'paid' => 'مدفوع',
            'balance_due' => 'الرصيد المستحق',
            'notes' => 'ملاحظات',
        ],
    ],
    'settings' => [
        'status' => [
            'title' => 'إعدادات حالة الفاتورة',
            'description' => 'تعديل حالات الفواتير وتغيير الأيقونات والألوان',
            'action' => [
                'edit' => 'تعديل الحالة',
                'notification' => 'تم تعديل الحالة بنجاح',
            ],
            'columns' => [
                'status' => 'الحالة',
                'icon' => 'أيقونة',
                'color' => 'لون',
                'language' => 'اللغة',
                'value' => 'القيمة',
            ]
        ],
    ],
];
