<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use SammyK\LaravelFacebookSdk\SyncableGraphNodeTrait;

class User extends Authenticatable
{
    use Notifiable;

    use SyncableGraphNodeTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'facebook_user_id', 'access_token', 'image_url'
    ];

    protected static $graph_node_fillable_fields = ['name', 'email', 'facebook_user_id', 'image_url'];

    protected static $graph_node_field_aliases = [
        'id' => 'facebook_user_id',
        
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'access_token'
    ];
}
