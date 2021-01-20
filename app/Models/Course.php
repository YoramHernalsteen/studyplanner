<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Chapter;

class Course extends Model
{
    use HasFactory;

    public function getName(){
        return $this->name;
    }
    public function getExamForm(){
        return $this->exam_form;
    }
    public function getUserId(){
        return $this->user_id;
    }
    public function setName($name){
        $this->name = $name;
    }
    public function setExamForm($examForm){
        $this->exam_form = $examForm;
    }
    public function setUserId($userId){
        $this->user_id = $userId;
    }
    public function getChapters(){
        return $this->hasMany(Chapter::class);
    }
    public function randomColor(){
        $colors = ['#ffadad', '#ffd6a5', '#fdffb6', '#caffbf', '#A0C4FF','#BDB2FF', '#a0c4ff', '#ffc6ff', '#9bf6ff'];
        return $colors[rand(0, count($colors)-1)];
    }
    public function getColor(){
        return $this->color_scheme;
    }
    public function setColor($color){
        $this->color_scheme = $color;
    }
    public function getDifficulty(){
        return $this->difficulty_index;
    }
    public function getDifficultyString(){
        if($this->getDifficulty() == 0.75){
            return "easy";
        } else if($this->getDifficulty() == 1){
            return "normal";
        }
        return "hard";
    }
    public function setDifficulty($difficulty){
        $this->difficulty_index = $difficulty;
    }
    public function chapterCount(){
        return $this->getChapters->count();
    }
    public function period(){
        return $this->belongsTo(Period::class, 'period_id');
    }
    public function getCompletedChaptersAbsolute(){
        return $this->hasMany(Chapter::class)->where('status', '=', 'done')->count();
    }
    public function getCompletedChaptersAbsolutePercent(){
        if($this->chapterCount()==0){
            return 0;
        }
        return round(($this->getCompletedChaptersAbsolute()/$this->chapterCount())*100, 2);
    }
    public function getTotalPages(){
        $pages =0;
        foreach ($this->getChapters as $chapter){
            $pages += $chapter->getPages();
        }
        return $pages;
    }
    public function getPagesCompleted(){
        $pages =0;
        foreach ($this->getChapters as $chapter){
            if($chapter->getStatus()=== 'done'){
                $pages += $chapter->getPages();
            }
        }
        return $pages;
    }

    public function getPagesCompletedPercent(){
        if($this->getTotalPages() == 0){
            return 0;
        }
        return round(($this->getPagesCompleted()/$this->getTotalPages())*100 , 2);
    }

    public function studyRate(){
        $completed = $this->getPagesCompletedPercent();
        $daysPercentage = $this->period->daysCompleted();
        return round(($completed/$daysPercentage),2);
    }

}
