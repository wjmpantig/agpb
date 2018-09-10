<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    
    public function altNames(){
    	return $this->hasMany('App\AltName');
    }

    public function media(){
    	return $this->hasMany('App\Media');
    }
}
