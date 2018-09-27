<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // Table name
    protected $table = 'posts';

    // Primary Key
    public $primaryKey = 'id';

    // Timestamps - If we didn't want the 2 created_at and updated_at timestamps, set this to false
    public $timestamps = true;
    
    public function country(){
        return $this->belongsTo('App\Country');
    }

    public function city(){
        return $this->belongsTo('App\City');
    }

}
