<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    //
    protected $guarded = [];

    protected $casts = [
        'philgeps_validity' => 'date',
        'business_permit_validity' => 'date',
        'dti_permit_validity' => 'date',
    ];
}
