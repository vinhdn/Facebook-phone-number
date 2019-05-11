<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;
    const STATUS_NOT_CONFIRM = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DEACTIVATE = 2;

    protected $rememberTokenName = 'api_token';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password' , 'otp'
    ];


    /**
     * @param array $params
     * @return bool|mixed
     */
    public function checkUserLogin($params = [], $isCheckCode = true)
    {
        $params = [
            'email' => $params['email'],
            'password' => $params['password'],
            'admin_code' => isset($params['admin_code']) ? $params['admin_code'] : null,
        ];
        $user = self::getUserByEmail($params['email']);
        if (!$user) {
            return false;
        }
        if(!Hash::check($params['password'], $user->password)) {
            return false;
        }
        if(!$isCheckCode) {
            return $user;
        }
        $adminCode = DB::table('admin_code')->first()->code;
        if($params['admin_code'] == $adminCode) {
            return $user;
        } else {
            return false;
        }
    }

    /**
     *
     * Find user with password not hash
     * @param $email
     * @return mixed
     */
    private function getUserByEmail($email)
    {
        $user = self::select()
            ->where('email', $email)
            ->first();
        return $user;
    }
    /**
     *
     * Find user with password not hash
     * @param $email
     * @return mixed
     */
    public function getUserById($id)
    {
        $user = self::select()
            ->where('id', $id)
            ->first();
        return $user;
    }

    public function getListUser() {
        $users = self::select()
            ->get();
        return $users;
    }

}
