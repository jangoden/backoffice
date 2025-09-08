<?php

namespace App\Filament\Resources\TemplateWebsiteResource\Pages;

use App\Filament\Resources\TemplateWebsiteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTemplateWebsite extends EditRecord
{
    protected static string $resource = TemplateWebsiteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
