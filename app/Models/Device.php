<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $casts = [
        'first_deployed_at' => 'date',
    ];

    public function getHealthStatus(): array
    {
        // Случай 1: Дата не установлена
        if (is_null($this->first_deployed_at)) {
            return ['status' => 'N/A', 'percentage' => null, 'color' => 'gray'];
        }

        $startDate = $this->first_deployed_at;
        $endDate = $this->first_deployed_at->copy()->add($this->health_lifecycle_value, $this->health_lifecycle_unit);
        $now = Carbon::now();

        // Случай 2: Устройство еще не "устарело" или дата в будущем (для безопасности)
        if ($now < $startDate || $endDate <= $startDate) {
            return ['status' => 'Perfect', 'percentage' => 0, 'color' => 'success'];
        }

        // Случай 3: Жизненный цикл уже прошел
        if ($now >= $endDate) {
            return ['status' => 'Poor', 'percentage' => 100, 'color' => 'danger'];
        }

        $totalDuration = $endDate->diffInSeconds($startDate);
        $elapsedDuration = $now->diffInSeconds($startDate);

        $percentage = round(($elapsedDuration / $totalDuration) * 100);

        return match (true) {
            $percentage <= 25 => ['status' => 'Perfect', 'percentage' => $percentage, 'color' => 'success'],
            $percentage <= 50 => ['status' => 'Good', 'percentage' => $percentage, 'color' => 'info'],
            $percentage <= 75 => ['status' => 'Fair', 'percentage' => $percentage, 'color' => 'warning'],
            default => ['status' => 'Poor', 'percentage' => $percentage, 'color' => 'danger'],
        };
    }
}
