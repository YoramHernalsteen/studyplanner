<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    public function getDate(){
        return $this->date;
    }
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

    public function examPlanner(){
        return $this->belongsTo(ExamPlanner::class);
    }
}
