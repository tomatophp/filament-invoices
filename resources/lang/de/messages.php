<?php

// german translations

return [
    'invoices' => [
        'title' => 'Rechnungen',
        'group' => 'Zahlungen',
        'single' => 'Rechnung',
        'widgets' => [
            'count' => 'Gesamtanzahl Rechnungen',
            'paid' => 'Gesamtbetrag bezahlt',
            'due' => 'Gesamtbetrag fällig'
        ],
        'columns' => [
            'uuid' => 'Rechnungsnummer',
            'name' => 'Kundenname',
            'phone' => 'Telefonnummer',
            'address' => 'Adresse',
            'date' => 'Rechnungsdatum',
            'due_date' => 'Fälligkeitsdatum',
            'type' => 'Rechnungstyp',
            'status' => 'Status',
            'currency_id' => 'Währung',
            'items' => 'Rechnungspositionen',
            'item' => 'Position',
            'item_name' => 'Position Name',
            'description' => 'Beschreibung',
            'qty' => 'Menge',
            'price' => 'Preis',
            'discount' => 'Rabatt',
            'vat' => 'MwSt',
            'total' => 'Gesamt',
            'shipping' => 'Versand',
            'notes' => 'Notizen',
            'account' => 'Konto',
            'by' => 'von',
            'from' => 'Von',
            'paid' => 'Bezahlt',
            'updated_at' => 'Aktualisiert am',
        ],
        'sections' => [
            'from_type' => [
                'title' => 'Absender Typ',
                'columns' => [
                    'from_type' => 'Absender Typ',
                    'from' => 'Aus',
                ],
            ],
            'billed_from' => [
                'title' => 'Abgerechnet von',
                'columns' => [
                    'for_type' => 'Für Typ',
                    'for' => 'Für',
                ],
            ],
            'customer_data' => [
                'title' => 'Kundendaten',
                'columns' => [
                    'name' => 'Name',
                    'phone' => 'Telefon',
                    'address' => 'Adresse',
                ],
            ],
            'invoice_data' => [
                'title' => 'Rechnungsdaten',
                'columns' => [
                    'date' => 'Datum',
                    'due_date' => 'Fälligkeitsdatum',
                    'type' => 'Typ',
                    'status' => 'Status',
                    'currency' => 'Währung',
                ],
            ],
            'totals' => [
                'title' => 'Summen'
            ],
        ],
        'filters' => [
            'status' => 'Status',
            'type' => 'Typ',
            'due' => [
                'label' => 'Fälligkeitsdatum',
                'columns' => [
                    'overdue' => 'Überfällig',
                    'today' => 'Heute',
                ]
            ],
            'for' => [
                'label' => 'Filtern nach Für',
                'columns' => [
                    'for_type' => 'Für Typ',
                    'for_name' => 'Für Name',
                ]
            ],
            'from' => [
                'label' => 'Filtern nach Von',
                'columns' => [
                    'from_type' => 'Von Typ',
                    'from_name' => 'Von Name',
                ]
            ],
        ],
        'actions' => [
            'total' => 'Gesamt',
            'paid' => 'Bezahlt',
            'amount' => 'Betrag',
            'view_invoice' => 'Rechnung ansehen',
            'edit_invoice' => 'Rechnung bearbeiten',
            'archive_invoice' => 'Rechnung archivieren',
            'delete_invoice_forever' => 'Rechnung endgültig löschen',
            'restore_invoice' => 'Rechnung wiederherstellen',
            'invoices_status' => 'Rechnungsstatus',
            'print' => 'Drucken',
            'pay' => [
                'label' => 'Bezahlen',
                'notification' => [
                    'title' => 'Rechnung bezahlt',
                    'body' => 'Rechnung erfolgreich bezahlt'
                ]
            ],
            'status' => [
                'title' => 'Status',
                'label' => 'Status ändern',
                'tooltip' => 'Status der ausgewählten Rechnungen ändern',
                'form' => [
                    'model_id' => 'Benutzer',
                    'model_type' => 'Benutzertyp',
                ],
                'notification' => [
                    'title' => 'Status geändert',
                    'body' => 'Status erfolgreich geändert'
                ]
            ],
        ],
        'logs' => [
            'title' => 'Rechnungslogs',
            'single' => 'Rechnungslog',
            'columns' => [
                'log' => 'Log',
                'type' => 'Typ',
                'created_at' => 'Erstellt am',
            ],
        ],
        'payments' => [
            'title' => 'Zahlungen',
            'single' => 'Zahlung',
            'columns' => [
                'amount' => 'Betrag',
                'created_at' => 'Erstellt am',
            ],
        ],
        'view' => [
            'bill_from' => 'Rechnung von',
            'bill_to' => 'Rechnung an',
            'invoice' => 'Rechnung',
            'issue_date' => 'Ausstellungsdatum',
            'due_date' => 'Fälligkeitsdatum',
            'status' => 'Status',
            'type' => 'Typ',
            'item' => 'Position',
            'total' => 'Gesamt',
            'price' => 'Preis',
            'vat' => 'MwSt',
            'discount' => 'Rabatt',
            'qty' => 'Menge',
            'bank_account' => 'Bankkonto',
            'name' => 'Name',
            'address' => 'Adresse',
            'branch' => 'Zweig',
            'swift' => 'Swift',
            'account' => 'Konto',
            'owner' => 'Besitzer',
            'iban' => 'IBAN',
            'signature' => 'Unterschrift',
            'subtotal' => 'Zwischensumme',
            'tax' => 'Steuer',
            'paid' => 'bezahlt',
            'balance_due' => 'Fälliger Betrag',
            'notes' => 'Notizen',
        ]
    ],
    'settings' => [
        'status' => [
            'title' => 'Rechnungsstatus Einstellungen',
            'description' => 'Ändern Sie Ihre Rechnungsfarben und Rechnungstext',
            'action' => [
                'edit' => 'Status bearbeiten',
                'notification' => 'Status erfolgreich aktualisiert',
            ],
            'columns' => [
                'status' => 'Status',
                'icon' => 'Icon',
                'color' => 'Farbe',
                'language' => 'Sprache',
                'value' => 'Wert',
            ]
        ],
    ],
];