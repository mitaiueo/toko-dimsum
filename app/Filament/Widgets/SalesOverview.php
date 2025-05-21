<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SalesOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Sales', 'Rp ' . number_format(Transaction::where('payment_status', 'paid')->sum('total_amount'), 0, ',', '.'))
                ->description('Total completed sales')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart(Transaction::where('payment_status', 'paid')
                    ->selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
                    ->groupBy('date')
                    ->orderBy('date')
                    ->limit(7)
                    ->pluck('total')
                    ->toArray()),

            Stat::make('Total Products', Product::count())
                ->description(Product::where('is_active', true)->count() . ' active products')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('primary'),

            Stat::make('Total Customers', User::where('id', '!=', 1)->count())
                ->description('Registered users')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('warning'),
        ];
    }
}
