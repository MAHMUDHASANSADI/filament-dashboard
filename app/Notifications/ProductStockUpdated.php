<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class ProductStockUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Product $product,
        public int $oldStock,
        public int $newStock,
        public int $quantity,
        public string $action,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return \Filament\Notifications\Notification::make()
            ->title("Stock " . ucfirst($this->action) . "d")
            ->body($this->message())
            ->info()
            ->getDatabaseMessage();
    }

    private function message(): string
    {
        if ($this->action === 'increase') {
            return "{$this->product->name} stock increased by {$this->quantity}. "
                . "Stock: {$this->oldStock} → {$this->newStock}";
        }

        return "{$this->product->name} stock decreased by {$this->quantity}. "
            . "Stock: {$this->oldStock} → {$this->newStock}";
    }
}
