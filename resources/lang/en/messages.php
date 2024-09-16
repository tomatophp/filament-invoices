<?php

return [
    'invoices' => [
        'title' => 'Invoices',
        'group' => 'Payments',
        'single' => 'Invoice',
        'widgets' => [
            'count' => 'Total Invoices',
            'paid' => 'Total Paid Money',
            'due' => 'Total Due'
        ],
        'columns' => [
            'uuid' => 'Invoice ID',
            'name' => 'Customer Name',
            'phone' => 'Phone Number',
            'address' => 'Address',
            'date' => 'Invoice Date',
            'due_date' => 'Due Date',
            'type' => 'Invoice Type',
            'status' => 'Status',
            'currency_id' => 'Currency',
            'items' => 'Invoice Items',
            'item' => 'Item',
            'item_name' => 'Item Name',
            'description' => 'Description',
            'qty' => 'Quantity',
            'price' => 'Price',
            'discount' => 'Discount',
            'vat' => 'VAT',
            'total' => 'Total',
            'shipping' => 'Shipping',
            'notes' => 'Notes',
            'account' => 'Account',
            'by' => 'by',
            'from' => 'From',
            'paid' => 'Paid',
            'updated_at' => 'Updated At',
        ],
        'sections' => [
            'from_type' => [
                'title' => 'From type',
                'columns' => [
                    'from_type' => 'From type',
                    'from' => 'From',
                ],
            ],
            'billed_from' => [
                'title' => 'Billed From',
                'columns' => [
                    'for_type' => 'For type',
                    'for' => 'For',
                ],
            ],
            'customer_data' => [
                'title' => 'Customer Data',
                'columns' => [
                    'name' => 'Name',
                    'phone' => 'Phone',
                    'address' => 'Address',
                ],
            ],
            'invoice_data' => [
                'title' => 'Invoice Data',
                'columns' => [
                    'date' => 'Date',
                    'due_date' => 'Due date',
                    'type' => 'Type',
                    'status' => 'Status',
                    'currency' => 'Currency',
                ],
            ],
            'totals' => [
                'title' => 'Totals'
            ],
        ],
        'filters' => [
            'status' => 'Status',
            'type' => 'Type',
            'due' => [
                'label' => 'Due Date',
                'columns' => [
                    'overdue' => 'Over Due',
                    'today' => 'Today',
                ]
            ],
            'for' => [
                'label' => 'Filter By For',
                'columns' => [
                    'for_type' => 'For Type',
                    'for_name' => 'For Name',
                ]
            ],
            'from' => [
                'label' => 'Filter By From',
                'columns' => [
                    'from_type' => 'From Type',
                    'from_name' => 'From Name',
                ]
            ],
        ],
        'actions' => [
            'total' => 'Total',
            'paid' => 'Paid',
            'amount' => 'Amount',
            'view_invoice' => 'View Invoice',
            'edit_invoice' => 'Edit Invoice',
            'archive_invoice' => 'Archive Invoice',
            'delete_invoice_forever' => 'Delete Invoice Forever',
            'restore_invoice' => 'Restore Invoice',
            'invoices_status' => 'Invoices Status',
            'print' => 'Print',
            'pay' => [
                'label' => 'Pay For Invoice',
                'notification' => [
                    'title' => 'Invoice Paid',
                    'body' => 'Invoice Paid Successfully'
                ]
            ],
            'status' => [
                'title' => 'Status',
                'label' => 'Change Status',
                'tooltip' => 'Change Status of Selected Invoices',
                'form' => [
                    'model_id' => 'Users',
                    'model_type' => 'User Type',
                ],
                'notification' => [
                    'title' => 'Status Changed',
                    'body' => 'Status Changed Successfully'
                ]
            ],
        ],
        'logs' => [
            'title' => 'Invoice Logs',
            'single' => 'Invoice Log',
            'columns' => [
                'log' => 'Log',
                'type' => 'Type',
                'created_at' => 'Created at',
            ],
        ],
        'payments' => [
            'title' => 'Payments',
            'single' => 'Payment',
            'columns' => [
                'amount' => 'Amount',
                'created_at' => 'Created at',
            ],
        ],
        'view' => [
            'bill_from' => 'Bill From',
            'bill_to' => 'Bill To',
            'invoice' => 'Invoice',
            'issue_date' => 'Issue Date',
            'due_date' => 'Due Date',
            'status' => 'Status',
            'type' => 'Type',
            'item' => 'Item',
            'total' => 'Total',
            'price' => 'Price',
            'vat' => 'VAT',
            'discount' => 'Discount',
            'qty' => 'QTY',
            'bank_account' => 'Bank Account',
            'name' => 'Name',
            'address' => 'Address',
            'branch' => 'Branch',
            'swift' => 'Swift',
            'account' => 'Account',
            'owner' => 'Owner',
            'iban' => 'IBAN',
            'signature' => 'Signature',
            'subtotal' => 'Sub Total',
            'tax' => 'Tax',
            'paid' => 'paid',
            'balance_due' => 'Balance Due',
            'notes' => 'Notes',
        ]
    ],
    'settings' => [
        'status' => [
            'title' => 'Order Status Settings',
            'description' => 'Change your order status colors and text',
            'action' => [
                'edit' => 'Edit Status',
                'notification' => 'Status Updated Successfully',
            ],
            'columns' => [
                'status' => 'Status',
                'icon' => 'Icon',
                'color' => 'Color',
                'language' => 'Language',
                'value' => 'Value',
            ]
        ],
    ],
];
