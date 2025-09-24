<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class MSDUserInfo extends Model
{
    protected $connection = 'mysql-msd';
    protected $table = 'userinfo';
    protected $primaryKey = 'userID';

    public function getAllCos(){
        return $this->where(['status' => "COS", "is_active" => 1])->get();
    }
}
