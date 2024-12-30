<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookRatingResource\Pages;
use App\Models\BookRating;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class BookRatingResource extends Resource
{
    protected static ?string $model = BookRating::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    protected static ?string $navigationGroup = 'Other';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('book.name')
                    ->label('Book'),
                TextColumn::make('student.nim')
                    ->label('NPM'),
                TextColumn::make('student.name')
                    ->label('Name'),
                TextColumn::make('student.academic.name')
                    ->label('Academic'),
                TextColumn::make('created_at')
                    ->label('Rating Date'),
                TextColumn::make('rating')
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
            'index' => Pages\ListBookRatings::route('/'),
            'create' => Pages\CreateBookRating::route('/create'),
            'edit' => Pages\EditBookRating::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }
}
