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
