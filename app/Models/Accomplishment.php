<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accomplishment extends Model
{
    //
    protected $guarded = [];
    protected $casts = [
        'date' => 'datetime'
    ];

    public function task() {
        return $this->belongsTo(Task::class);
    }
}
