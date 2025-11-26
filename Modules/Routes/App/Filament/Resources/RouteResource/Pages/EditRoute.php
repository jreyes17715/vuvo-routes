<?php

namespace Modules\Routes\App\Filament\Resources\RouteResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Modules\Routes\App\Filament\Resources\RouteResource;

class EditRoute extends EditRecord
{
    protected static string $resource = RouteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}