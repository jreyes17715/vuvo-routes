<?php

namespace App\Filament\Resources\WarehouseResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products';

    // Título de la sección en el Admin
    protected static ?string $title = 'Inventario Actual';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name') // Busca productos por nombre
            ->columns([
                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Producto')
                    ->searchable(),

                // AQUÍ ESTÁ LA CLAVE: Mostramos el dato de la tabla intermedia (Pivot)
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Cantidad')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Botón para "Cargar" producto a la bodega/camión
                Tables\Actions\AttachAction::make()
                    ->preloadRecordSelect() // Carga lista de productos
                    ->form(fn (Tables\Actions\AttachAction $action): array => [
                        $action->getRecordSelect(),
                        // Campo extra para definir cuántos metemos
                        Forms\Components\TextInput::make('quantity')
                            ->label('Cantidad a Cargar')
                            ->numeric()
                            ->default(1)
                            ->required(),
                    ]),
            ])
            ->actions([
                // Botón para editar la cantidad (Inventario rápido)
                Tables\Actions\EditAction::make()
                    ->label('Ajustar Stock')
                    ->form([
                        Forms\Components\TextInput::make('quantity')
                            ->label('Cantidad Real')
                            ->numeric()
                            ->required(),
                    ]),

                // Botón para sacar el producto de la lista (Stock 0 o error)
                Tables\Actions\DetachAction::make()
                    ->label('Eliminar'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }
}