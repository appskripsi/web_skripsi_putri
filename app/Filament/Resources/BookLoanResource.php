<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookLoanResource\Pages;
use App\Models\BookLoan;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class BookLoanResource extends Resource
{
    protected static ?string $model = BookLoan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'User';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('status')
                    ->label('Loan Status')
                    ->options([
                        BookLoan::pending_status => 'Pending',
                        BookLoan::approved_status => 'Approved',
                        BookLoan::completed_status => 'Completed'
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student.name')
                    ->label('Student'),
                TextColumn::make('book.name')
                    ->label('Book'),
                TextColumn::make('start_date')
                    ->label('Start Date'),
                TextColumn::make('end_date')
                    ->label('End Date'),
                TextColumn::make('status')
                    ->label('Loan Status')
                    ->badge()
                    ->formatStateUsing(fn($state) => match ($state) {
                        BookLoan::pending_status => 'Pending',
                        BookLoan::approved_status => 'Approved',
                        BookLoan::completed_status => 'Completed'
                    }),
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
            'index' => Pages\ListBookLoans::route('/'),
            'create' => Pages\CreateBookLoan::route('/create'),
            'edit' => Pages\EditBookLoan::route('/{record}/edit'),
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
}
