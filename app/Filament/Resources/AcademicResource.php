<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AcademicResource\Pages;
use App\Models\Academic;
use App\Models\Faculty;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AcademicResource extends Resource
{
    protected static ?string $model = Academic::class;

    protected static ?string $navigationIcon = 'heroicon-m-academic-cap';
    protected static ?string $navigationGroup = 'Academic';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Academic Data')
                    ->schema([
                        TextInput::make('name')
                            ->Label('Academic Name')
                            ->required()
                            ->string()
                            ->unique(ignoreRecord: true),
                        Select::make('faculty_id')
                            ->label('Faculty')
                            ->options(function () {
                                return Faculty::pluck('name', 'id')->toArray();
                            })
                            ->required(),
                        Toggle::make('status')
                            ->label('Status'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('faculty.name'),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn($state) => $state ? 'Active' : 'Inactive'),
            ])
            ->filters([

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
            'index' => Pages\ListAcademics::route('/'),
            'create' => Pages\CreateAcademic::route('/create'),
            'edit' => Pages\EditAcademic::route('/{record}/edit'),
        ];
    }
}
