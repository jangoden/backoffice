<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TemplateWebsiteResource\Pages;
use App\Models\Template;
use App\Models\TemplateCategory; // <-- Tambahkan ini
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str; // <-- Tambahkan ini

class TemplateWebsiteResource extends Resource
{
    protected static ?string $model = Template::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    
    // Bonus: Mengelompokkan menu di sidebar
    protected static ?string $navigationGroup = 'Template Management'; 
    protected static ?string $modelLabel = 'Website Template';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug($state))),

                // Slug akan dibuat otomatis dan read-only
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->readOnly()
                    ->unique(Template::class, 'slug', ignoreRecord: true),
                
                // INI BAGIAN UTAMA YANG DIUBAH
                Forms\Components\Select::make('template_category_id')
                    ->label('Category')
                    ->relationship('templateCategory', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug($state))),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->readOnly()
                            ->unique(TemplateCategory::class, 'slug'),
                    ]),

                Forms\Components\TextInput::make('demo_url') // Disesuaikan dengan nama kolom di migration
                    ->label('Demo URL')
                    ->required()
                    ->url()
                    ->maxLength(255),

                Forms\Components\FileUpload::make('image_preview') // Disesuaikan dengan nama kolom di migration
                    ->label('Image Preview')
                    ->image()
                    ->disk('public')
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
                Tables\Columns\ImageColumn::make('image_preview') // Disesuaikan
                    ->label('Image'),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                
                // Menampilkan nama kategori dari relasi
                Tables\Columns\TextColumn::make('templateCategory.name')
                    ->label('Category')
                    ->searchable()
                    ->sortable(),

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