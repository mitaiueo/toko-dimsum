<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use App\Models\TransactionItem;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class TopSellingProducts extends BaseWidget
{
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Top Selling Products')
            ->description('Most popular items in your shop')
            ->query(
                Product::query()
                    ->addSelect(['total_sold' => TransactionItem::query()
                        ->selectRaw('SUM(quantity)')
                        ->whereColumn('product_id', 'products.id')
                        ->join('transactions', 'transactions.id', '=', 'transaction_items.transaction_id')
                        ->where('transactions.payment_status', '=', 'paid')
                    ])
                    ->orderByDesc('total_sold')
                    ->take(5)
            )
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->square(),
                
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('price')
                    ->money('IDR')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('stock')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('total_sold')
                    ->label('Total Sold')
                    ->sortable(),
            ]);
    }
}
