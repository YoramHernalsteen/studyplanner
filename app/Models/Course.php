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
        $colors = ['#ffadad', '#ffd6a5', '#fdffb6', '#caffbf', '#a0c4ff', '#ffc6ff', '#9bf6ff'];
        return $colors[rand(0, count($colors)-1)];
    }
    public function chapterCount(){
        return $this->getChapters->count();
    }
    public function period(){
        return $this->belongsTo(Period::class, 'period_id');
    }
}
