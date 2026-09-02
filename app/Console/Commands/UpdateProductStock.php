<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('product:stock
    {slug : The product slug}
    {--increase= : Quantity to increase}
    {--decrease= : Quantity to decrease}')]
#[Description('Increase or decrease product stock')]
class UpdateProductStock extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $slug = $this->argument('slug');
        $increase = $this->option('increase');
        $decrease = $this->option('decrease');

        /*
         * Exactly one operation must be provided.
         */
        if ($increase === null && $decrease === null) {
            $this->error('Please provide either --increase or --decrease.');

            return self::FAILURE;
        }

        if ($increase !== null && $decrease !== null) {
            $this->error('You cannot use --increase and --decrease together.');

            return self::FAILURE;
        }

        /*
         * Validate quantities before modifying the database.
         */
        if ($increase !== null && (! is_numeric($increase) || $increase < 1)) {
            $this->error('Increase quantity must be a positive number.');

            return self::FAILURE;
        }

        if ($decrease !== null && (! is_numeric($decrease) || $decrease < 1)) {
            $this->error('Decrease quantity must be a positive number.');

            return self::FAILURE;
        }

        /*
         * Find product.
         */
        $product = Product::where('slug', $slug)->first();

        if (! $product) {
            $this->error('Product not found.');

            return self::FAILURE;
        }

        /*
         * Determine operation.
         */
        $action = $increase !== null ? 'increase' : 'decrease';
        $quantity = (int) ($increase ?? $decrease);

        $oldStock = (int) $product->stock;

        $newStock = $action === 'increase'
            ? $oldStock + $quantity
            : $oldStock - $quantity;

        /*
         * Optional protection against negative stock.
         */
        if ($newStock < 0) {
            $this->error(
                "Cannot decrease stock by {$quantity}. Current stock is {$oldStock}."
            );

            return self::FAILURE;
        }

        /*
         * Update once.
         */
        $product->update([
            'stock' => $newStock,
        ]);

        /*
         * Send Filament database notification.
         */
        User::query()->eachById(function (User $user) use (
            $product,
            $oldStock,
            $newStock,
            $quantity,
            $action
        ) {
            Notification::make()
                ->title('Product stock updated')
                ->success()
                ->body(
                    "Product {$product->name} stock was {$action}d by {$quantity}. "
                        . "Stock changed from {$oldStock} to {$newStock}."
                )
                ->sendToDatabase($user);
        });

        $this->newLine();

        $this->info('Product stock updated successfully.');

        $this->table(
            ['Product', 'Action', 'Quantity', 'Old Stock', 'New Stock'],
            [[
                $product->name,
                ucfirst($action),
                $quantity,
                $oldStock,
                $newStock,
            ]]
        );

        return self::SUCCESS;
    }
}
