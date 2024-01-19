<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'folder_path'
    ];

    public function configs()
    {
        return $this->hasMany('App\Models\Config', 'folder_id', 'id');
    }

}
