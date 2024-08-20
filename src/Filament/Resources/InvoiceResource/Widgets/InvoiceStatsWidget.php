<?php

namespace TomatoPHP\FilamentInvoices\Filament\Resources\InvoiceResource\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use TomatoPHP\FilamentInvoices\Models\Invoice;

class InvoiceStatsWidget extends StatsOverviewWidget
{
    public function getStats(): array
    {
        $query = Invoice::query();
        return [
            StatsOverviewWidget\Stat::make(trans('filament-invoices::messages.invoices.widgets.count'), "")
                ->icon('heroicon-o-currency-dollar')
                ->color('info')
                ->chart([65, 59, 80, 81, 56, 55, 40])
                ->value((clone $query)->count()),
            StatsOverviewWidget\Stat::make(trans('filament-invoices::messages.invoices.widgets.paid') , "")
                ->icon('heroicon-o-currency-dollar')
                ->color('success')
                ->chart([65, 59, 80, 81, 56, 55, 40])
                ->value(number_format((clone $query)->where('status', 'paid')->sum('total'), 2)),
            StatsOverviewWidget\Stat::make(trans('filament-invoices::messages.invoices.widgets.due'), "")
                ->icon('heroicon-o-currency-dollar')
                ->color('danger')
                ->chart([65, 59, 80, 81, 56, 55, 40])
                ->value(number_format(collect(
                    (clone $query)
                        ->where('status', '!=','paid')
                        ->where('status', '!=','cancelled')
                        ->where('status', '!=','estimate')
                        ->get()
                )->sum(fn($item)=>($item->total - $item->paid)), 2)),
        ];
    }
}
