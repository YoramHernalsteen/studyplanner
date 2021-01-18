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
}
