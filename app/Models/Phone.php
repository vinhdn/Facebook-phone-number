<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    protected $table = 'zft_phones';   
    protected $primaryKey = 'id';
    protected $fillable = ['phone', 'uid'];

    /**
     *
     * Find user with password not hash
     * @param $email
     * @return mixed
     */
    public function getPhoneByUid($uid)
    {
        $phone = self::select()
            ->where('uid', $uid)
            ->first();
        if($phone) {
            return $phone->phone;
        }
        return null;
    }
}
