<?php

namespace App\Casts;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class ExecutionStatusCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if ($value == 0){
            return 'running';
        }

        else if ($value == 1){
           $date_time = $model->start_time;
           $diffHuman = Carbon::now()->diffForHumans($date_time, CarbonInterface::DIFF_ABSOLUTE);
           return "After ".$diffHuman;
        }
        else {
            return 'expired';
        }

    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return $value;
    }
}
