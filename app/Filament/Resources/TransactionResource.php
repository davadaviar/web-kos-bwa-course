<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
                Forms\Components\TextInput::make('code')
                ->required(),

                Forms\Components\Select::make('boarding_house_id')
                ->relationship('boardingHouse', 'name')
                ->required(),

                Forms\Components\Select::make('room_id')
                ->relationship('room', 'name')
                ->required(),

                Forms\Components\TextInput::make('name')
                ->maxLength(255)
                ->required(),

                Forms\Components\TextInput::make('email')
                ->email()
                ->required(),

                Forms\Components\TextInput::make('phone_number')
                ->required(),

                Forms\Components\Select::make('payment_method')
                ->options([
                    'down_payment' => 'Down Payment',
                    'full_payment' => 'Full Payment',
                ])
                ->required(),

                Forms\Components\Select::make('payment_status')
                ->options([
                    'pending' => 'Pending',
                    'paid' => 'Paid',
                ])
                ->required(),

                Forms\Components\DatePicker::make('start_date')
                ->required(),

                Forms\Components\TextInput::make('duration')
                ->numeric()
                ->required(),

                Forms\Components\TextInput::make('total_amount')
                ->numeric()
                ->prefix('IDR')
                ->required(),

                Forms\Components\DatePicker::make('transaction_date')
                ->required(),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                
                Tables\Columns\TextColumn::make('code'),
                Tables\Columns\TextColumn::make('boardingHouse.name'),
                Tables\Columns\TextColumn::make('room.name'),
                Tables\Columns\TextColumn::make('payment_method'),
                Tables\Columns\TextColumn::make('payment_status'),
                Tables\Columns\TextColumn::make('total_amount'),
                Tables\Columns\TextColumn::make('transaction_date'),

            ])
            ->filters([
                //
            ])
            ->actions([

                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
