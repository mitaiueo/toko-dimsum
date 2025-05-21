<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class OrdersChart extends ChartWidget
{
    protected static ?string $heading = 'Monthly Orders';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = $this->getOrdersData();
        
        return [
            'datasets' => [
                [
                    'label' => 'Orders',
                    'data' => $data['values'],
                    'backgroundColor' => '#A31D1D',
                    'borderColor' => '#A31D1D',
                ],
            ],
            'labels' => $data['labels'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
    
    protected function getOrdersData(): array
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();
        
        // Get transactions for the last 6 months
        $months = collect([]);
        $values = collect([]);
        
        for ($i = 5; $i >= 0; $i--) {
            $month = $now->copy()->subMonths($i)->format('F');
            $startDate = $now->copy()->subMonths($i)->startOfMonth()->format('Y-m-d');
            $endDate = $now->copy()->subMonths($i)->endOfMonth()->format('Y-m-d');
            
            $count = Transaction::whereBetween('created_at', [$startDate, $endDate])->count();
            
            $months->push($month);
            $values->push($count);
        }
        
        return [
            'labels' => $months->toArray(),
            'values' => $values->toArray(),
        ];
    }
}
