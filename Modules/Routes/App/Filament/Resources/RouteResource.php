<?php

namespace Modules\Routes\App\Filament\Resources;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Modules\Routes\App\Models\Route;
use Modules\Inventory\App\Models\Warehouse;
use Modules\Clients\App\Models\ClientBranch;
use Modules\Routes\App\Filament\Resources\RouteResource\Pages;

class RouteResource extends Resource
{
    protected static ?string $model = Route::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';
    protected static ?string $navigationGroup = 'Logística';
    protected static ?string $label = 'Ruta de Distribución';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // SECCIÓN 1: DATOS DE CABECERA
                Forms\Components\Section::make('Detalles de la Ruta')
                    ->columns(3)
                    ->schema([
                        Forms\Components\DatePicker::make('scheduled_date')
                            ->label('Fecha Programada')
                            ->default(now())
                            ->required(),

                        Forms\Components\Select::make('driver_id')
                            ->relationship('driver', 'name')
                            ->label('Conductor')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\Select::make('warehouse_id')
                            ->label('Unidad (Camión)')
                            // Filtramos solo almacenes móviles
                            ->options(Warehouse::where('is_mobile', true)->pluck('plate_number', 'id'))
                            ->searchable()
                            ->required(),

                        Forms\Components\Select::make('status')
                            ->options([
                                'draft' => 'Borrador',
                                'scheduled' => 'Programada',
                                'active' => 'En Ruta',
                                'completed' => 'Completada',
                            ])
                            ->default('draft')
                            ->required(),
                    ]),

                // SECCIÓN 2: PARADAS (REPEATER)
                Forms\Components\Section::make('Itinerario de Visitas')
                    ->schema([
                        Forms\Components\Repeater::make('stops')
                            ->relationship()
                            ->schema([
                                Forms\Components\Select::make('client_branch_id')
                                    ->label('Punto de Entrega')
                                    ->options(function () {
                                        return ClientBranch::with('client')->get()
                                            ->mapWithKeys(function ($branch) {
                                                return [$branch->id => "{$branch->client->name} - {$branch->name}"];
                                            });
                                    })
                                    ->searchable()
                                    ->required()
                                    ->columnSpan(2),

                                Forms\Components\TextInput::make('notes')
                                    ->label('Notas')
                                    ->placeholder('Ej: Cobrar cheque')
                                    ->columnSpan(1),
                            ])
                            ->columns(3)
                            ->itemLabel(fn (array $state): ?string => 
                                isset($state['client_branch_id']) 
                                    ? ClientBranch::find($state['client_branch_id'])?->full_name 
                                    : null
                            )
                            ->addActionLabel('Agregar Parada')
                            ->reorderableWithButtons()
                            ->defaultItems(0),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('scheduled_date')
                    ->date('d/m/Y')
                    ->label('Fecha')
                    ->sortable(),

                Tables\Columns\TextColumn::make('driver.name')
                    ->label('Chofer')
                    ->searchable(),

                Tables\Columns\TextColumn::make('warehouse.plate_number')
                    ->label('Placa Unidad')
                    ->icon('heroicon-m-truck'),

                Tables\Columns\TextColumn::make('stops_count')
                    ->counts('stops')
                    ->label('Paradas')
                    ->badge(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'gray' => 'draft',
                        'warning' => 'scheduled',
                        'info' => 'active',
                        'success' => 'completed',
                    ]),
            ])
            ->filters([
                //
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoutes::route('/'),
            'create' => Pages\CreateRoute::route('/create'),
            'edit' => Pages\EditRoute::route('/{record}/edit'),
        ];
    }
}