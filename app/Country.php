<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    // Table name
    public $table = 'countries';

    // Primary Key
    public $primaryKey = 'id';

    // Timestamps - If we didn't want the 2 created_at and updated_at timestamps, set this to false
    public $timestamps = false;

    public function cities(){
        return $this->hasMany('App\City');
    }
}
