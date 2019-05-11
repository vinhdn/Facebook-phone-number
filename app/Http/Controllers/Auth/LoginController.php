<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests\StoreUpdatePostFormRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;
use App\Models\Phone;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    private $userModel;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->userModel = $user;
        Auth::guard("web")->logout();
        $this->middleware('guest')->except('logout');
    }

    public function index() {
        return view('auth.login', []);
    }

    public function logout() {
        Auth::guard('manager')->logout();
        return redirect(route('login'));
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|min:5',
        ]);
        if ($validator->fails()) {
            return redirect(route('login'))
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        $user = $this->userModel->checkUserLogin($data, false);
        if (!$user) {
            return redirect(route('login'))
                ->withErrors(['message' => 'Thông tin đăng nhập không chính xác'])
                ->withInput();
        }
        if($user->status == 2) {
            return redirect(route('login'))
                ->withErrors(['message' => 'Tài khoản đang bị khóa'])
                ->withInput();
        }
        if($user->status == 0) {
            return redirect(route('login'))
                ->withErrors(['message' => 'Tài khoản chưa được kích hoạt'])
                ->withInput();
        }
        if($user->type != 0) {
            return redirect(route('login'))
            ->withErrors(['message' => 'Bạn không có quyền truy cập'])
            ->withInput();
        }
        $user->api_token = hash('sha256', Str::random(60));
        if($user->save()) {
            Auth::guard('manager')->login($user);
            return redirect(route('home'));
        } else {
            return redirect(route('login'))
            ->withErrors(['message' => 'Đã có lỗi xảy ra vui lòng thử lại.'])
            ->withInput();
        }
    }
}
