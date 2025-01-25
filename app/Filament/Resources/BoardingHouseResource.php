<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BoardingHouseResource\Pages;
use App\Filament\Resources\BoardingHouseResource\RelationManagers;
use App\Models\BoardingHouse;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class BoardingHouseResource extends Resource
{
    protected static ?string $model = BoardingHouse::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
                Forms\Components\Tabs::make('Tabs')
                ->tabs([

                    // Tab Informasi umum
                    Forms\Components\Tabs\Tab::make('General info')
                        ->schema([

                            Forms\Components\FileUpload::make('thumbnail')
                            ->image()
                            ->directory('boarding_houses')
                            ->required(),
                            
                            Forms\Components\TextInput::make('name')
                            ->maxLength(255)
                            ->reactive()
                            ->afterStateUpdated(
                                function ($state, callable $set) 
                                {
                                    $set('slug', Str::slug($state));
                                }
                            )
                            ->debounce(500)
                            ->required(),

                            Forms\Components\TextInput::make('slug')
                            ->required(),

                            Forms\Components\Select::make('city_id')
                            ->relationship('city', 'name')
                            ->required(),

                            Forms\Components\Select::make('category_id')
                            ->relationship('category', 'name')
                            ->required(),

                            Forms\Components\RichEditor::make('description')
                            ->required(),

                            Forms\Components\TextInput::make('price')
                            ->numeric()
                            ->prefix('IDR')
                            ->required(),

                            Forms\Components\Textarea::make('address')
                            ->required(),

                        ]),

                        // Tab kamar
                        Forms\Components\Tabs\Tab::make('Room')
                        ->schema([
                            
                            Forms\Components\Repeater::make('rooms')
                            ->relationship('rooms')
                            ->schema([

                                Forms\Components\TextInput::make('name')
                                ->maxLength(255)
                                ->required(),
                                
                                Forms\Components\TextInput::make('room_type')
                                ->maxLength(255)
                                ->required(),

                                Forms\Components\TextInput::make('capacity')
                                ->maxLength(255)
                                ->required(),

                                Forms\Components\TextInput::make('square_feet')
                                ->numeric()
                                ->required(),

                                Forms\Components\TextInput::make('price_per_month')
                                ->numeric()
                                ->prefix('IDR')
                                ->required(),

                                Forms\Components\Toggle::make('is_available')
                                ->default(true),

                                Forms\Components\Repeater::make('images')
                                ->relationship('roomImages')
                                ->schema([
                                    
                                    Forms\Components\FileUpload::make('image')
                                    ->image()
                                    ->directory('rooms')
                                    ->required(),

                                ])
                                ->grid(3),

                            ])
                        ]),

                        // Tab bonus
                        Forms\Components\Tabs\Tab::make('Bonus')
                        ->schema([
                            
                            Forms\Components\Repeater::make('bonuses')
                            ->relationship('bonuses')
                            ->schema([
                                
                                Forms\Components\FileUpload::make('image')
                                ->image()
                                ->directory('bonuses')
                                ->required(),

                                Forms\Components\TextInput::make('name')
                                ->maxLength(255)
                                ->required(),

                                Forms\Components\Textarea::make('description')
                                ->required(),
                            ])
                        ]),
                ])
                ->columnSpan(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListBoardingHouses::route('/'),
            'create' => Pages\CreateBoardingHouse::route('/create'),
            'edit' => Pages\EditBoardingHouse::route('/{record}/edit'),
        ];
    }
}
