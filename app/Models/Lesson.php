<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    public function getStartTime(){
        $date = new DateTime($this->start_time);

        return $date->format('H:i');
    }
    public function getEndTime(){
        $date = new DateTime($this->end_time);

        return $date->format('H:i');
    }

    public function course(){
        return $this->belongsTo(Course::class);
    }
}
