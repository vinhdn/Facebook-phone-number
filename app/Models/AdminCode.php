<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminCode extends Model
{
    protected $fillable = ['code'];
    protected $table = "admin_code";

    function getAdminCode() {
        $code = self::select($this->listField).first()->admin_code;
    }
}
