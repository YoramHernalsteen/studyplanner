<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamPlanner extends Model
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
        if(date("D", strtotime($this->getStartDate())) == 'Mon'){
            $current = strtotime($this->getStartDate());
        } else{
            $current =date(strtotime('previous monday', strtotime($this->getStartDate())));
        }
        if(date("D", strtotime($this->getStartDate())) == 'Sun'){
            $last = strtotime($this->getEndDate());
        } else{
            $last =date(strtotime('next sunday', strtotime($this->getEndDate())));
        }
        while( $current <= $last ) {
            $dates[] = date($output_format, $current);
            $current = strtotime($step, $current);
        }
        return $dates;
    }

    public function examsOnDay($day){
        $day = strtr($day, '/', '-');
        $date = date('Y-m-d', strtotime($day));
        return $this->hasMany(Exam::class)->where('date', '=', $date)->orderBy('start_time', 'ASC')->get();
    }
    public function studySessionsOnDay($day){
        $day = strtr($day, '/', '-');
        $date = date('Y-m-d', strtotime($day));
        return $this->hasMany(StudySession::class)->where('date', '=', $date)->get();
    }

    public function dayExtraInfo($day){
        $day = strtr($day, '/', '-');
        return date('l d/m/Y', strtotime($day));
    }
    public function dayFormatConverter($day){
        $day = strtr($day, '/', '-');
        return date('Y-m-d', strtotime($day));
    }

}
