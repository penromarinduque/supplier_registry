<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    protected $guarded = [];

    public function accomplishments()
    {
        return $this->hasMany(Accomplishment::class);
    }
}
