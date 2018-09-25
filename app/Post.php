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
    public $timestamp = true;

}
