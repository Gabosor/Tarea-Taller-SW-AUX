<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Validation\ValidationException;
class Screening extends Model
{
    use HasFactory;
    protected $fillable = ['movie_id', 'room_id', 'start_time', 'end_time', 'price', 'duration'];
    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

     protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $startTime = Carbon::parse($model->start_time);
            $endTime = $startTime->copy()->addMinutes($model->duration);

            $conflict = Screening::where('room_id', $model->room_id)
                ->where(function ($query) use ($startTime, $endTime) {
                    $query->whereBetween('start_time', [$startTime, $endTime])
                          ->orWhereBetween('end_time', [$startTime, $endTime])
                          ->orWhere(function ($query) use ($startTime, $endTime) {
                              $query->where('start_time', '<', $startTime)
                                    ->where('end_time', '>', $endTime);
                          });
                })
                ->exists();

            if ($conflict) {
                throw ValidationException::withMessages(['start_time' => 'La sala no está disponible en la hora seleccionada.']);
            }

            $model->end_time = $endTime;
        });
    }
}
