<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon   = 'heroicon-o-briefcase'; // ikon khusus portfolio
    protected static ?string $navigationGroup  = 'Portfolio';            // ← pindah grup
    protected static ?int    $navigationSort   = 1;                      // urutan di dalam grup
    protected static ?string $modelLabel       = 'Project';
    protected static ?string $pluralModelLabel = 'Projects';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('title')
                ->label('Title')
                ->required()
                ->maxLength(255),

            TextInput::make('github_link')
                ->label('GitHub Link')
                ->url()
                ->activeUrl()
                ->required(),
        ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('github_link')
                    ->label('GitHub')
                    ->copyable()
                    ->url(fn ($record) => $record->github_link, true)
                    ->wrap(),
            ])
            ->defaultSort('title')
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
            'index'  => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit'   => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
