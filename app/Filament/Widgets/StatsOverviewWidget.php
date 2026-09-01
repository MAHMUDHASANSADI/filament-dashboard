<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalProducts  = Product::count();
        $lowStockCount  = Product::where('stock', '<=', 5)->count();
        $totalCategories = Category::count();

        return [
            Stat::make('Total Products', $totalProducts)
                ->description('All products in store')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('primary'),

            Stat::make('Low Stock Products', $lowStockCount)
                ->description('Stock ≤ 5 units')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($lowStockCount > 0 ? 'danger' : 'success'),

            Stat::make('Total Categories', $totalCategories)
                ->description('Active categories')
                ->descriptionIcon('heroicon-m-tag')
                ->color('success'),
        ];
    }
}
