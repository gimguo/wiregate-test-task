<?php

namespace App\Filament\Widgets;

use App\Models\Device;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Collection;

class DeviceStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $statuses = Device::all()->map(function (Device $device) {
            return $device->getHealthStatus()['status'];
        });

        $statusCounts = $statuses->countBy();

        return [
            Stat::make('Perfect', $statusCounts->get('Perfect', 0)),
            Stat::make('Good', $statusCounts->get('Good', 0)),
            Stat::make('Fair', $statusCounts->get('Fair', 0)),
            Stat::make('Poor', $statusCounts->get('Poor', 0)),
        ];
    }
}
