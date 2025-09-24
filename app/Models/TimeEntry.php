<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeEntry extends Model
{
    //
    protected $guarded = [];

    protected $casts = [
        'am_in' => 'datetime',
        'pm_in' => 'datetime',
        'am_out' => 'datetime',
        'pm_out' => 'datetime',
        'date' => 'datetime',
    ];


}
