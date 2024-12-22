<?php

return [
    'invoices' => [
        'title' => 'Faturas',
        'group' => 'Pagamentos',
        'single' => 'Fatura',
        'widgets' => [
            'count' => 'Total de Faturas',
            'paid' => 'Total Pago',
            'due' => 'Total Devido'
        ],
        'columns' => [
            'uuid' => 'ID da Fatura',
            'name' => 'Nome do Cliente',
            'phone' => 'Número de Telefone',
            'address' => 'Endereço',
            'date' => 'Data da Fatura',
            'due_date' => 'Data de Vencimento',
            'type' => 'Tipo de Fatura',
            'status' => 'Status',
            'currency_id' => 'Moeda',
            'items' => 'Itens da Fatura',
            'item' => 'Item',
            'item_name' => 'Nome do Item',
            'description' => 'Descrição',
            'qty' => 'Quantidade',
            'price' => 'Preço',
            'discount' => 'Desconto',
            'vat' => 'IVA',
            'total' => 'Total',
            'shipping' => 'Frete',
            'notes' => 'Observações',
            'account' => 'Conta',
            'by' => 'por',
            'from' => 'De',
            'paid' => 'Pago',
            'updated_at' => 'Atualizado Em',
        ],
        'sections' => [
            'from_type' => [
                'title' => 'Tipo de Remetente',
                'columns' => [
                    'from_type' => 'Tipo de Remetente',
                    'from' => 'De',
                ],
            ],
            'billed_from' => [
                'title' => 'Cobrado De',
                'columns' => [
                    'for_type' => 'Tipo de Destinatário',
                    'for' => 'Para',
                ],
            ],
            'customer_data' => [
                'title' => 'Dados do Cliente',
                'columns' => [
                    'name' => 'Nome',
                    'phone' => 'Telefone',
                    'address' => 'Endereço',
                ],
            ],
            'invoice_data' => [
                'title' => 'Dados da Fatura',
                'columns' => [
                    'date' => 'Data',
                    'due_date' => 'Data de Vencimento',
                    'type' => 'Tipo',
                    'status' => 'Status',
                    'currency' => 'Moeda',
                ],
            ],
            'totals' => [
                'title' => 'Totais'
            ],
        ],
        'filters' => [
            'status' => 'Status',
            'type' => 'Tipo',
            'due' => [
                'label' => 'Data de Vencimento',
                'columns' => [
                    'overdue' => 'Atrasado',
                    'today' => 'Hoje',
                ]
            ],
            'for' => [
                'label' => 'Filtrar por Destinatário',
                'columns' => [
                    'for_type' => 'Tipo de Destinatário',
                    'for_name' => 'Nome do Destinatário',
                ]
            ],
            'from' => [
                'label' => 'Filtrar por Remetente',
                'columns' => [
                    'from_type' => 'Tipo de Remetente',
                    'from_name' => 'Nome do Remetente',
                ]
            ],
        ],
        'actions' => [
            'total' => 'Total',
            'paid' => 'Pago',
            'amount' => 'Valor',
            'view_invoice' => 'Visualizar Fatura',
            'edit_invoice' => 'Editar Fatura',
            'archive_invoice' => 'Arquivar Fatura',
            'delete_invoice_forever' => 'Excluir Fatura Permanentemente',
            'restore_invoice' => 'Restaurar Fatura',
            'invoices_status' => 'Status das Faturas',
            'print' => 'Imprimir',
            'pay' => [
                'label' => 'Pagar Fatura',
                'notification' => [
                    'title' => 'Fatura Paga',
                    'body' => 'Fatura paga com sucesso'
                ]
            ],
            'status' => [
                'title' => 'Status',
                'label' => 'Alterar Status',
                'tooltip' => 'Alterar o Status das Faturas Selecionadas',
                'form' => [
                    'model_id' => 'Usuários',
                    'model_type' => 'Tipo de Usuário',
                ],
                'notification' => [
                    'title' => 'Status Alterado',
                    'body' => 'Status alterado com sucesso'
                ]
            ],
        ],
        'logs' => [
            'title' => 'Logs da Fatura',
            'single' => 'Log da Fatura',
            'columns' => [
                'log' => 'Log',
                'type' => 'Tipo',
                'created_at' => 'Criado Em',
            ],
        ],
        'payments' => [
            'title' => 'Pagamentos',
            'single' => 'Pagamento',
            'columns' => [
                'amount' => 'Valor',
                'created_at' => 'Criado Em',
            ],
        ],
        'view' => [
            'bill_from' => 'Cobrado De',
            'bill_to' => 'Cobrado Para',
            'invoice' => 'Fatura',
            'issue_date' => 'Data de Emissão',
            'due_date' => 'Data de Vencimento',
            'status' => 'Status',
            'type' => 'Tipo',
            'item' => 'Item',
            'total' => 'Total',
            'price' => 'Preço',
            'vat' => 'IVA',
            'discount' => 'Desconto',
            'qty' => 'Qtd',
            'bank_account' => 'Conta Bancária',
            'name' => 'Nome',
            'address' => 'Endereço',
            'branch' => 'Agência',
            'swift' => 'SWIFT',
            'account' => 'Conta',
            'owner' => 'Proprietário',
            'iban' => 'IBAN',
            'signature' => 'Assinatura',
            'subtotal' => 'Subtotal',
            'tax' => 'Imposto',
            'paid' => 'Pago',
            'balance_due' => 'Saldo Devido',
            'notes' => 'Observações',
        ]
    ],
    'settings' => [
        'status' => [
            'title' => 'Configurações de Status do Pedido',
            'description' => 'Altere as cores e textos do status do pedido',
            'action' => [
                'edit' => 'Editar Status',
                'notification' => 'Status atualizado com sucesso',
            ],
            'columns' => [
                'status' => 'Status',
                'icon' => 'Ícone',
                'color' => 'Cor',
                'language' => 'Idioma',
                'value' => 'Valor',
            ]
        ],
    ],
];
