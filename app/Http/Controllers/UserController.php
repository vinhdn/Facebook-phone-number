<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class UserController extends Controller
{
    private $userModel;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->userModel = $user;
        if (!Auth::guard('manager')->check()) {
            return redirect()->route("login");
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::guard('manager')->check()) {
            return redirect()->route("login");
        }
        $listUser = $this->userModel->getListUser();
        return view('users.index', compact('listUser'));
    }


    /**
     * Code
     *
     * @return \Illuminate\Http\Response
     */
    public function code()
    {
        if (!Auth::guard('manager')->check()) {
            return redirect()->route("login");
        }
        $adminCode = DB::table('admin_code')->first()->code;
        return view('users.code', compact('adminCode'));
    }


    /**
     * Code
     *
     * @return \Illuminate\Http\Response
     */
    public function resetCode()
    {
        if (!Auth::guard('manager')->check()) {
            return redirect()->route("login");
        }
        $newCode = strtoupper(Str::random(5));
        DB::table('admin_code')->truncate();
        DB::table('admin_code')->insert(['code' => $newCode]);
        DB::table('users')->where('type', 1)->update(['api_token' => null]);
        $adminCode = DB::table('admin_code')->first()->code;
        return redirect(route('users.code', ['adminCode' => $adminCode]));
    }

    /**
     * Cập nhật trạng thái của người dùng
     */
    public function updateStatus($id, $status) {
        if (!Auth::guard('manager')->check()) {
            return redirect()->route("login");
        }
        $newStatus = $status;
        if($newStatus > User::STATUS_DEACTIVATE) {
            $newStatus = User::STATUS_ACTIVE;
        }
        $user = $this->userModel->getUserById($id);
        if($user) {
            $user->api_token = hash('sha256', Str::random(60));
            $user->status = $newStatus;
            $user->save();
        }
        $listUser = $this->userModel->getListUser();
        return redirect(route('users.index', ['listUser' => $listUser]));
    }


    /**
     * Cập nhật mật khẩu của người dùng
     */
    public function resetPassword(Request $data) {
        if (!Auth::guard('manager')->check()) {
            return redirect()->route("login");
        }
        $validator = Validator::make($data->all(), [
            'id' => 'required',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return redirect(route('users.resetPasswordIndex'))
                ->withErrors($validator)
                ->withInput();
        }
        $user = $this->userModel->getUserById($data['id']);
        if($user) {
            $user->api_token = hash('sha256', Str::random(60));
            $user->password = Hash::make($data['password']);
            $user->save();
        }
        $listUser = $this->userModel->getListUser();
        return redirect(route('users.index', ['listUser' => $listUser]));
    }

    /**
     * Màn hình cập nhật mật khẩu của người dùng
     */
    public function resetPasswordIndex($id) {
        if (!Auth::guard('manager')->check()) {
            return redirect()->route("login");
        }
        if (!$id) {
            return redirect()->back();
        }
        $user = $this->userModel->getUserById($id);
        if($user) {
            return view('users.resetPassword', compact('user'));
        } else {
            return redirect()->back();
        }
    }
}
