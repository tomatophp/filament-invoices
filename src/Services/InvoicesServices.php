<?php

namespace TomatoPHP\FilamentInvoices\Services;

use Illuminate\Support\Collection;
use TomatoPHP\FilamentInvoices\Services\Contracts\InvoiceFor;
use TomatoPHP\FilamentInvoices\Services\Contracts\InvoiceFrom;
use TomatoPHP\FilamentTypes\Models\Type;

class InvoicesServices
{
    public array $from = [];
    public array $for = [];

    public function registerFrom(array|InvoiceFrom $from): void
    {
        if(is_array($from)) {
            foreach ($from as $from) {
                $this->registerFrom($from);
            }
        }
        else {
            $this->from[] = $from;
        }
    }

    public function registerFor(array|InvoiceFor $for): void
    {
        if(is_array($for)) {
            foreach ($for as $for) {
                $this->registerFor($for);
            }
        }
        else {
            $this->for[] = $for;
        }
    }

    public function getFrom(): Collection
    {
        return collect($this->from);
    }

    public function getFor(): Collection
    {
        return collect($this->for);
    }


    public function create(): CreateInvoice
    {
        return new CreateInvoice();
    }


    public function loadTypes()
    {
        $types = [
            [
                'type' => 'status',
                'name' => [
                    'ar' => 'مسودة',
                    'en' => 'Draft',
                ],
                'key' => 'draft',
                'icon' => 'heroicon-c-document',
                'color' => '#cf1919'
            ],
            [
                'type' => 'status',
                'name' => [
                    'ar' => 'مرسل',
                    'en' => 'Sent',
                ],
                'key' => 'sent',
                'icon' => 'heroicon-c-forward',
                'color' => '#49d941'
            ],
            [
                'type' => 'status',
                'name' => [
                    'ar' => 'ملغى',
                    'en' => 'Cancelled',
                ],
                'key' => 'cancelled',
                'icon' => 'heroicon-c-x-circle',
                'color' => '#d9d9d9'
            ],
            [
                'type' => 'status',
                'name' => [
                    'ar' => 'مدفوع',
                    'en' => 'Paid',
                ],
                'key' => 'paid',
                'icon' => 'heroicon-c-currency-dollar',
                'color' => '#0f2ed4'
            ],
            [
                'type' => 'status',
                'name' => [
                    'ar' => 'متأخر',
                    'en' => 'Overdue',
                ],
                'key' => 'overdue',
                'icon' => 'heroicon-c-clock',
                'color' => '#ccd611'
            ],
            [
                'type' => 'type',
                'name' => [
                    'ar' => 'فاتورة مشتريات',
                    'en' => 'Push Invoice',
                ],
                'key' => 'push',
                'icon' => 'heroicon-c-archive-box-arrow-down',
                'color' => '#b910e3'
            ],
            [
                'type' => 'type',
                'name' => [
                    'ar' => 'فاتورة مبيعات',
                    'en' => 'Sale Invoice',
                ],
                'key' => 'sale',
                'icon' => 'heroicon-c-arrow-trending-up',
                'color' => '#e809d8'
            ],
            [
                'type' => 'type',
                'name' => [
                    'ar' => 'عرض سعر',
                    'en' => 'Estimate',
                ],
                'key' => 'estimate',
                'icon' => 'heroicon-c-arrow-down-on-square-stack',
                'color' => '#1ae0a5'
            ],
        ];

        foreach ($types as $type){
            $exists = Type::query()
                ->where('for', 'invoices')
                ->where('type', $type['type'])
                ->where('key', $type['key'])
                ->first();
            if(!$exists){
                $type['for'] = 'invoices';
                $type['type'] = $type['type'];
                $exists = Type::create($type);
            }
        }
    }
}
