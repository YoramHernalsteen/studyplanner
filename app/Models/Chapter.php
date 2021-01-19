<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    public function getName(){
        return $this->name;
    }
    public function getPages(){
        return $this->pages;
    }
    public function getStatus(){
        return $this->status;
    }
    public function course(){
        return $this->belongsTo(Course::class);
    }
    public function setCourse($course){
        $this->course_id = $course;
    }
    public function setName($name){
        $this->name = $name;
    }
    public function setPages($pages){
        $this->pages = $pages;
    }
    public function setStatus($status){
        $this->status = $status;
    }
}
