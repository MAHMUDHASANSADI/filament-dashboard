<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ProductStockWidget extends BaseWidget
{
    protected static ?string $heading = 'Product Stock Levels';

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                fn() => Product::query()->with('category')->orderBy('stock', 'asc')
            )
            ->columns([
                TextColumn::make('name')
                    ->label('Product')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable(),

                TextColumn::make('stock')
                    ->label('Stock')
                    ->sortable()
                    ->badge()
                    ->color(fn($state) => match (true) {
                        $state <= 0  => 'danger',
                        $state <= 5  => 'warning',
                        default      => 'success',
                    }),

                TextColumn::make('price')
                    ->label('Price')
                    ->money('USD')
                    ->sortable(),
            ])
            ->paginated([10, 25, 50]);
    }
}
