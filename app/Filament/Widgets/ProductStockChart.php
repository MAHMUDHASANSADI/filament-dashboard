<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Widgets\ChartWidget;

class ProductStockChart extends ChartWidget
{
    protected ?string $heading = 'Stock Levels by Product';

    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $products = Product::query()
            ->orderByDesc('stock')
            ->limit(10)
            ->get(['name', 'stock']);

        return [
            'datasets' => [
                [
                    'label'           => 'Stock Quantity',
                    'data'            => $products->pluck('stock')->toArray(),
                    'backgroundColor' => $products->map(function ($p) {
                        if ($p->stock <= 0)  return 'rgba(239,68,68,0.7)';
                        if ($p->stock <= 5)  return 'rgba(245,158,11,0.7)';
                        return 'rgba(16,185,129,0.7)';
                    })->toArray(),
                    'borderColor'     => $products->map(function ($p) {
                        if ($p->stock <= 0)  return 'rgb(239,68,68)';
                        if ($p->stock <= 5)  return 'rgb(245,158,11)';
                        return 'rgb(16,185,129)';
                    })->toArray(),
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $products->pluck('name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
