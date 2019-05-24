<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SearchLog extends Model
{
    protected $table = 'search_log';   
    protected $primaryKey = ['fbId', 'userId'];
    protected $fillable = ['fbId', 'userId', 'phone', 'url', 'fbName'];
    public $incrementing = false;

    /**
     *
     * Find user with password not hash
     * @param $email
     * @return mixed
     */
    public function searchHistories($uid)
    {
        $histories = self::select()
            ->where('userId', $uid)
            ->get();
        return $histories;
    }
    
    public function isExistHistories($uid, $fbId)
    {
        $histories = self::select()
            ->whereRaw('fbId = ? and userId = ?', [$uid, $fbId])
            ->delete();
        return $histories;
    }
}
