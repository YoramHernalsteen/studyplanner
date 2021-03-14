<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudySession extends Model
{
    use HasFactory;

    public function getDate(){
        return $this->date;
    }

    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function examPlanner(){
        return $this->belongsTo(ExamPlanner::class);
    }

    public function getExtraInfo(){
        return $this->extra_info;
    }
    public function getHours(){
        return $this->hours;
    }
}
