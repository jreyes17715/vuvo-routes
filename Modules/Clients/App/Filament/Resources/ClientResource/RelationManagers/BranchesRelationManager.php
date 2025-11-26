<?php

namespace Modules\Clients\App\Filament\Resources\ClientResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class BranchesRelationManager extends RelationManager
{
    protected static string $relationship = 'branches'; // Nombre de la relación en el modelo Client
    protected static ?string $title = 'Sucursales / Puntos de Entrega';
    protected static ?string $icon = 'heroicon-o-map-pin';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre de Sucursal')
                    ->placeholder('Ej: Tienda La Esperanza')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\TextInput::make('code')
                    ->label('Código Interno')
                    ->placeholder('Ej: SUC-001'),

                Forms\Components\TextInput::make('address')
                    ->label('Dirección Física')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('latitude')
                            ->label('Latitud')
                            ->numeric()
                            ->default(0),
                        Forms\Components\TextInput::make('longitude')
                            ->label('Longitud')
                            ->numeric()
                            ->default(0),
                    ]),

                Forms\Components\TextInput::make('contact_name')
                    ->label('Encargado'),
                
                Forms\Components\TextInput::make('contact_phone')
                    ->label('Teléfono Sucursal')
                    ->tel(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nombre'),
                Tables\Columns\TextColumn::make('code')->label('Código'),
                Tables\Columns\TextColumn::make('address')->label('Dirección')->limit(30),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Nueva Sucursal'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}