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
        $current = strtotime($this->getStartDate());
        $last = strtotime($this->getEndDate());
        while( $current <= $last ) {
            $dates[] = date($output_format, $current);
            $current = strtotime($step, $current);
        }
        return $dates;
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
