<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RepositoryResource\Pages;
use App\Models\Academic;
use App\Models\Repository;
use App\Models\Student;
use App\Models\Type;
use Faker\Provider\ar_EG\Text;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use PhpParser\Node\Stmt\Label;

class RepositoryResource extends Resource
{
    protected static ?string $model = Repository::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Repository';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('code')
                    ->string()
                    ->required()
                    ->Label('Code'),
                Select::make('student_id')
                    ->required()
                    ->label('Student')
                    ->options(function () {
                        return Student::pluck('name', 'id')->toArray();
                    })
                    ->exists('tbl_mahasiswa', 'id'),
                TextInput::make('title')
                    ->string()
                    ->required(),
                Textarea::make('abstract')
                    ->required()
                    ->string(),
                TextInput::make('keywords')
                    ->required()
                    ->string(),
                Select::make('type_id')
                    ->options(function () {
                        return Type::where('status', 1)
                            ->pluck('name', 'id')
                            ->toArray();
                    })
                    ->required()
                    ->exists('tbl_tipe_repositori', 'id'),
                Select::make('academic_id')
                    ->label('Academic')
                    ->options(function () {
                        return Academic::where('status', 1)
                            ->pluck('name', 'id')
                            ->toArray();
                    })
                    ->required()
                    ->exists('tbl_program_studi', 'id'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->searchable(),
                TextColumn::make('academic.name')
                    ->label('Academic')
                    ->searchable(),
                TextColumn::make('student.name')
                    ->searchable(),
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('type.name')
                    ->badge(),
                TextColumn::make('keywords')
                    ->badge()
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
            'index' => Pages\ListRepositories::route('/'),
            'create' => Pages\CreateRepository::route('/create'),
            'edit' => Pages\EditRepository::route('/{record}/edit'),
        ];
    }
}
