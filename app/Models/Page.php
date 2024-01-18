<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'fb_id', 'description', 'access_token', 'access_token_expire_at', 'last_fetch_time'
    ];

    public function videos()
    {
        return $this->hasMany('App\Models\Video', 'id', 'page_id');
    }
 
}
