<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //Creating a user relataionship

    public function user(){
        return $this->belongsTo('App\User');
    }
}
