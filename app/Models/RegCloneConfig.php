<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegCloneConfig extends Model
{
    protected $connection = 'reg_clone';
    protected $table = 'configs';
    protected $guarded = ['id'];

}
