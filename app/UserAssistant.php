<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAssistant extends Model
{
    /**
     * @var string
     */
    protected $table = 'user_assistant';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'age', 'user_id'
    ];

    public function users()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
