<?php

namespace App\Models;

use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Week extends Model
{
    use HasFactory;

    public function getName(){
        return $this->name;
    }
    public function setName($name){
        $this->name = $name;
    }
    public function getStartDate(){
        return $this->start_date;
    }
    public function setStartDate($startDate){
        $this->start_date = $startDate;
    }
    public function getEndDate(){
        return $this->end_date;
    }
    public function setEndDate($endDate){
        $this->end_date = $endDate;
    }
    public function period(){
        return $this->belongsTo(Period::class);
    }
    public function setPeriod($period){
        $this->period_id = $period;
    }
    function getDays() {
        $step = '+1 day';
        $output_format = 'd/m/Y';
        $dates = array();
        $current = strtotime($this->getStartDate());
        $last = strtotime($this->getEndDate());
        while( $current <= $last ) {
            $dates[] = date($output_format, $current);
            $current = strtotime($step, $current);
        }
        return $dates;
    }
    public function lessons(){
        return $this->hasMany(Lesson::class);
    }
    public function homeWork(){
        return $this->hasMany(HomeWork::class);
    }

    public function homeWorkOnDay($day){
        $day = strtr($day, '/', '-');
        $date = date('Y-m-d', strtotime($day));
        return $this->homeWork()->where('date', '=', $date)->get();
    }

    public function lessonsOnDay($day){
        $day = strtr($day, '/', '-');
        $date = date('Y-m-d', strtotime($day));
        return $this->hasMany(Lesson::class)->where('date', '=', $date)->orderBy('start_time', 'ASC')->get();
    }

    public function dayFormatConverter($day){
        $day = strtr($day, '/', '-');
         return date('Y-m-d', strtotime($day));
    }

    public function dayExtraInfo($day){
        $day = strtr($day, '/', '-');
        return date('l d/m/Y', strtotime($day));
    }


}
