<?php
namespace Modules\Routes\App\Filament\Resources\DriverResource\Pages;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Modules\Routes\App\Filament\Resources\DriverResource;

class ListDrivers extends ListRecords {
    protected static string $resource = DriverResource::class;
    protected function getHeaderActions(): array { return [Actions\CreateAction::make()]; }
}