<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeviceResource\Pages;
use App\Filament\Resources\DeviceResource\RelationManagers;
use App\Models\Device;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions;
use Filament\Actions\ActionGroup;

class DeviceResource extends Resource
{
    protected static ?string $model = Device::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static bool $isScopedToTenant = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                DatePicker::make('first_deployed_at')
                    ->label('First Deployed Date')
                    ->maxDate(now()),

                TextInput::make('health_lifecycle_value')
                    ->label('Lifecycle Value')
                    ->required()
                    ->numeric(),

                Select::make('health_lifecycle_unit')
                    ->label('Lifecycle Unit')
                    ->required()
                    ->options([
                        'year' => 'Year(s)',
                        'month' => 'Month(s)',
                        'day' => 'Day(s)',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('health')
                ->label('Health')
                    ->badge()
                    ->state(function (Device $record): string {
                        return $record->getHealthStatus()['status'];
                    })
                    ->color(function (Device $record): string {
                        return $record->getHealthStatus()['color'];
                    }),
                TextColumn::make('name')->searchable(),
                TextColumn::make('first_deployed_at')
                    ->date()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('health_status')
                    ->label('Health Status')
                    ->options([
                        'perfect' => 'Perfect',
                        'good' => 'Good',
                        'fair' => 'Fair',
                        'poor' => 'Poor',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        $status = $data['value'];
                        if (blank($status)) {
                            return $query;
                        }

                        $deviceIds = Device::all()->filter(function ($device) use ($status) {
                            return strtolower($device->getHealthStatus()['status']) === $status;
                        })->pluck('id');

                        return $query->whereIn('id', $deviceIds);
                    })
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListDevices::route('/'),
            'create' => Pages\CreateDevice::route('/create'),
            'edit' => Pages\EditDevice::route('/{record}/edit'),
        ];
    }
}
