<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TemplateWebsiteResource\Pages;
use App\Filament\Resources\TemplateWebsiteResource\RelationManagers;
use App\Models\Template;
use App\Models\TemplateWebsite;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TemplateWebsiteResource extends Resource
{
    protected static ?string $model = Template::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo'; // Ganti ikon jika perlu

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('category')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('demoUrl')
                    ->label('Demo URL')
                    ->required()
                    ->url()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('imageUrl')
                    ->label('Image Preview')
                    ->image()
                    ->disk('public') // Pastikan storage Anda di-link (php artisan storage:link)
                    ->directory('templates')
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TagsInput::make('tags')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('imageUrl')
                    ->label('Image'),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListTemplateWebsites::route('/'),
            'create' => Pages\CreateTemplateWebsite::route('/create'),
            'edit' => Pages\EditTemplateWebsite::route('/{record}/edit'),
        ];
    }    
}