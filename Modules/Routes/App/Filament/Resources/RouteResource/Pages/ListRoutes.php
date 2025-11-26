<?php

namespace Modules\Routes\App\Filament\Resources\RouteResource\Pages; 

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Modules\Routes\App\Filament\Resources\RouteResource;

class ListRoutes extends ListRecords
{
    protected static string $resource = RouteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}