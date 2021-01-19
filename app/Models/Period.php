<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    use HasFactory;

    public function getUserId(){
        return $this->user_id;
    }
    public function getName(){
        return $this->name;
    }
    public function getDueDate(){
        return date("j F Y", strtotime($this->due_date));
    }
    public function getDaysToDueDate(){
        $dueDate = new DateTime(date($this->due_date));
        $today = new DateTime('today');
        return $today->diff($dueDate)->days;

    }
    public function getDaysBetweenStartAndDueDate(){
        $dueDate = new DateTime(date($this->due_date));
        $start = new DateTime(date($this->created_at));
        return $start->diff($dueDate)->days;
    }
    public function getDaysBetweenStartAndNow(){
        $start = new DateTime(date($this->created_at));
        $today = new DateTime('today');
        return $start->diff($today)->days;
    }
    public function setUserId($uid){
        $this->user_id = $uid;
    }
    public function setName($name){
        $this->name = $name;
    }
    public function setDueDate($date){
        $this->due_date = $date;
    }
    public function courses(){
        return $this->hasMany(Course::class);
    }
    public function getTotalChapters(){
        $total = 0;
        foreach ($this->courses as $course){
         $total += $course->chapterCount();
        }
        return $total;
    }
    public function getChaptersCompletedAbsolute(){
        $total = 0;
        if($this->courses == null || $this->getTotalChapters() == 0){
            return 0;
        }
        foreach ($this->courses as $course){
           foreach ($course->getChapters as $chapter){
               if($chapter->getStatus() === 'done'){
                   $total += 1;
               }
           }
        }
        return round(($total/$this->getTotalChapters())*100, 2);
    }
    public function daysCompleted(){
        $days = $this->getDaysBetweenStartAndDueDate() > 0 ? $this->getDaysBetweenStartAndDueDate() : 1;
        $daysLeft = $this->getDaysBetweenStartAndNow() > 0 ? $this->getDaysBetweenStartAndNow() : 1;
        return round(($daysLeft/$days)*100, 2);
    }

    public function studyRate(){
        $completed = $this->getChaptersCompletedAbsolute();
        $daysPercentage = $this->daysCompleted();
        return round(($completed/$daysPercentage),2);
    }

}
