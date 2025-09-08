<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms\Form;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon   = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup  = 'Content';
    protected static ?string $modelLabel       = 'Post';
    protected static ?string $pluralModelLabel = 'Posts';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('user_id')
                ->label('Author')
                ->relationship('user', 'name')
                ->searchable()
                ->preload()
                ->default(fn () => auth()->user()?->id)
                ->required(),

            TextInput::make('title')
                ->label('Title')
                ->required()
                ->maxLength(255)
                ->live(onBlur: true)
                ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug((string) $state))),

            TextInput::make('slug')
                ->label('Slug')
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true)
                ->helperText('Huruf kecil, pisah dengan tanda minus (-).'),

            Select::make('category_id')
                ->label('Category')
                ->relationship('category', 'name')
                ->searchable()
                ->preload()
                ->required(),

            Select::make('status')
                ->label('Status')
                ->options([
                    'draft'     => 'Draft',
                    'published' => 'Published',
                ])
                ->native(false)
                ->required()
                ->default('draft'),

            // Konten utama
            RichEditor::make('content')
                ->label('Content')
                ->toolbarButtons([
                    'bold','italic','strike','h2','h3','bulletList','orderedList',
                    'link','blockquote','codeBlock','undo','redo','attachFiles',
                    'align-left',
                    'align-center',
                    'align-right',
                    'align-justify',
                ])
                ->fileAttachmentsDisk('public')
                ->fileAttachmentsDirectory('posts/body')
                ->fileAttachmentsVisibility('public')
                ->required()
                ->columnSpanFull(),

            // Gambar unggulan
            FileUpload::make('featured_image')
                ->label('Featured Image')
                ->image()
                ->imageEditor()
                ->imagePreviewHeight('180')
                ->directory('post-images')     // hasil: post-images/xxx.jpg
                ->disk('public')
                ->visibility('public')
                ->maxSize(2048),

            DateTimePicker::make('published_at')
                ->label('Published At')
                ->seconds(false)
                ->helperText('Isi saat status = Published.'),
        ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Thumbnail
                Tables\Columns\ImageColumn::make('featured_image')
                    ->label('Image')
                    ->disk('public')
                    ->visibility('public')
                    ->getStateUsing(fn ($record) => $record->featured_image
                        ? ltrim(preg_replace('/^storage\//', '', (string) $record->featured_image), '/')
                        : null)
                    ->square()
                    ->height(48),

                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->badge()
                    ->sortable()
                    ->toggleable(),

                // Badge status di TABLE (bukan di form)
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'draft',
                        'success' => 'published',
                    ])
                    ->sortable(),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Published')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name'),

                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'draft'     => 'Draft',
                        'published' => 'Published',
                    ]),
            ])
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
            'index'  => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit'   => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
