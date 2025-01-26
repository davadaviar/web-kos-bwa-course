<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Filament\Resources\TestimonialResource\RelationManagers;
use App\Models\Testimonial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\FileUpload::make('photo')
                ->image()
                ->directory('testimonials')
                ->columnSpan(2)
                ->required(),
                
                Forms\Components\TextInput::make('name')
                ->maxLength(255)
                ->required(),
                
                Forms\Components\Select::make('boarding_house_id')
                ->relationship('boardingHouse', 'name')
                ->required(),

                Forms\Components\Textarea::make('content')
                ->maxLength(65535)
                ->required(),

                Forms\Components\TextInput::make('rating')
                ->minValue(1)
                ->maxValue(5)
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                
                Tables\Columns\ImageColumn::make('photo'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('boardingHouse.name'),
                Tables\Columns\TextColumn::make('rating'),
                
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
            'index' => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}
