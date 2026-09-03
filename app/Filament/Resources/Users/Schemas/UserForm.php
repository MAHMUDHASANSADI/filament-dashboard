<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),

                DateTimePicker::make('email_verified_at'),

                TextInput::make('password')
                    ->password()
                    ->minLength(8)
                    ->dehydrateStateUsing(
                        fn($state) => filled($state)
                            ? bcrypt($state)
                            : null
                    ),

                Toggle::make('is_admin')
                    ->label('Admin')
                    ->default(false),
            ]);
    }
}
