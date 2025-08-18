<?php

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;

class Device extends Model
{
    use HasFactory, Searchable;

    protected $casts = [
        'first_deployed_at' => 'date',
    ];

    protected $fillable = [
        'name',
        'first_deployed_at',
        'health_lifecycle_value',
        'health_lifecycle_unit',
    ];

    public function getHealthStatus(): array
    {
        if (is_null($this->first_deployed_at)) {
            return ['status' => 'N/A', 'percentage' => null, 'color' => 'gray'];
        }

        $startDate = $this->first_deployed_at;
        $endDate = $this->first_deployed_at->copy()->add($this->health_lifecycle_value, $this->health_lifecycle_unit);
        $now = Carbon::now();

        if ($now < $startDate || $endDate <= $startDate) {
            return ['status' => 'Perfect', 'percentage' => 0, 'color' => 'success'];
        }

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

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray(): array
    {
        $array = $this->toArray();
        $array['health_status'] = strtolower($this->getHealthStatus()['status']);

        return $array;
    }
}
