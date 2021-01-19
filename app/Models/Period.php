<?php

namespace App\Models;

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
        return $this->due_date;
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
}
