<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WarehouseResource\Pages;
use App\Filament\Resources\WarehouseResource\RelationManagers;
// IMPORTANTE: Conexión al modelo modular
use Modules\Inventory\app\Models\Warehouse;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Get; // Necesario para la lógica condicional
use App\Filament\Resources\WarehouseResource\RelationManagers\ProductsRelationManager; // <-- Importante

class WarehouseResource extends Resource
{
    protected static ?string $model = Warehouse::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationGroup = 'Inventario';
    protected static ?string $modelLabel = 'Bodega / Camión';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información General')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nombre')
                            ->placeholder('Ej: Bodega Central o Camión 01')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('address')
                            ->label('Dirección Física')
                            ->maxLength(255),
                    ]),

                Forms\Components\Section::make('Configuración de Logística')
                    ->schema([
                        // EL INTERRUPTOR MÁGICO
                        Forms\Components\Toggle::make('is_mobile')
                            ->label('¿Es una unidad móvil (Camión)?')
                            ->helperText('Activa esto si es un vehículo de reparto.')
                            ->live() // <--- IMPORTANTE: Hace que el formulario reaccione en vivo
                            ->columnSpanFull(),

                        // CAMPO CONDICIONAL: Solo se ve si is_mobile es TRUE
                        Forms\Components\TextInput::make('plate_number')
                            ->label('Número de Placa')
                            ->placeholder('Ej: P-123XYZ')
                            ->visible(fn (Get $get) => $get('is_mobile')) // Condición de visibilidad
                            ->required(fn (Get $get) => $get('is_mobile')), // Condición de obligatoriedad
                    ]),

                Forms\Components\Toggle::make('is_active')
                    ->label('Bodega Activa')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),

                // Icono para saber si es camión o edificio
                Tables\Columns\IconColumn::make('is_mobile')
                    ->label('Tipo')
                    ->boolean()
                    ->trueIcon('heroicon-o-truck')
                    ->falseIcon('heroicon-o-building-office')
                    ->trueColor('warning')
                    ->falseColor('primary'),

                Tables\Columns\TextColumn::make('plate_number')
                    ->label('Placa')
                    ->searchable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
            ])
            ->filters([
                // Filtro para ver solo camiones o solo bodegas
                Tables\Filters\Filter::make('only_mobile')
                    ->label('Solo Camiones')
                    ->query(fn ($query) => $query->where('is_mobile', true)),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            ProductsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWarehouses::route('/'),
            'create' => Pages\CreateWarehouse::route('/create'),
            'edit' => Pages\EditWarehouse::route('/{record}/edit'),
        ];
    }
}