<?php

namespace Modules\Clients\App\Filament\Resources;
use Modules\Clients\App\Filament\Resources\ClientResource\RelationManagers;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Modules\Clients\App\Models\Client;
use Modules\Clients\App\Filament\Resources\ClientResource\Pages;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';
    protected static ?string $navigationGroup = 'Comercial';
    protected static ?string $label = 'Cliente';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Razón Social / Nombre')
                    ->required(),
                Forms\Components\TextInput::make('tax_id')
                    ->label('NIT / RFC / RUC'),
                Forms\Components\TextInput::make('main_phone')
                    ->label('Teléfono Principal'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('tax_id'),
                Tables\Columns\TextColumn::make('branches_count')->counts('branches')->label('Sucursales'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }
    public static function getRelations(): array
    {
        return [
            RelationManagers\BranchesRelationManager::class,
        ];
    }
}