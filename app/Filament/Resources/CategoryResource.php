<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Content';
    protected static ?string $modelLabel = 'Category';
    protected static ?string $pluralModelLabel = 'Categories';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->label('Name')
                ->required()
                ->maxLength(100)
                ->live(onBlur: true)
                ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug((string) $state))),

            TextInput::make('slug')
                ->label('Slug')
                ->required()
                ->maxLength(120)
                ->unique(ignoreRecord: true)
                ->helperText('Huruf kecil, pisah dengan tanda minus (-).'),
        ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->copyable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('Y-m-d H:i')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
            ])
            ->defaultSort('name')
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit'   => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
