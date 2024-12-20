<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookResource\Pages;
use App\Models\Academic;
use App\Models\Book;
use App\Models\Category;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationIcon = 'heroicon-s-book-open';

    protected static ?string $navigationGroup = 'Book';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Book Name')
                    ->required()
                    ->string(),
                TextInput::make('author')
                    ->label('Book Author')
                    ->required()
                    ->string(),
                TextInput::make('location')
                    ->label('Book Location')
                    ->required()
                    ->string(),
                Select::make('category_id')
                    ->label('Book Category')
                    ->required()
                    ->options(function () {
                        return Category::pluck('name', 'id')->toArray();
                    }),
                Select::make('academic_id')
                    ->label('Book Academic')
                    ->required()
                    ->options(function () {
                        return Academic::pluck('name', 'id')->toArray();
                    }),
                Textarea::make('description')
                    ->label('Book Description')
                    ->nullable()
                    ->string(),
                FileUpload::make('image')
                    ->label('Book Image')
                    ->image()
                    ->imageResizeMode('cover')
                    ->imageResizeTargetWidth('183')
                    ->imageResizeTargetHeight('275')
                    ->uploadingMessage('Uploading image....')
                    ->maxSize(512)
                    ->required()
                    ->directory('book-image-cover'),
                TextInput::make('stock')
                    ->label('Book Stock')
                    ->integer()
                    ->required(),
                Select::make('level')
                    ->label('Difficult Level')
                    ->required()
                    ->options([
                        Book::easy_level => 'Mudah',
                        Book::medium_level => 'Sedang',
                        Book::hard_level => 'Sulit'
                    ]),
                TextInput::make('borrowed')
                    ->label('Total Borrowed')
                    ->integer()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                ImageColumn::make('image'),
                TextColumn::make('author')
                    ->searchable(),
                TextColumn::make('stock'),
                TextColumn::make('borrowed')
                    ->label('Total Borrowed'),
                TextColumn::make('category.name')
                    ->searchable(),
                TextColumn::make('academic.name')
                    ->searchable(),
                TextColumn::make('level')
                    ->formatStateUsing(fn($state) => match ($state) {
                        Book::easy_level => 'Mudah',
                        Book::medium_level => 'Sedang',
                        Book::hard_level => 'Sulit'
                    })

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
            'index' => Pages\ListBooks::route('/'),
            'create' => Pages\CreateBook::route('/create'),
            'edit' => Pages\EditBook::route('/{record}/edit'),
        ];
    }
}
