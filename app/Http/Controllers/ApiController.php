<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdatePostFormRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;
use App\Models\Phone;
use App\Models\User;
use App\Models\SearchLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Str;

class ApiController extends Controller
{
    private $post;
    private $phone;
    private $userModel;
    private $searchLog;

    public function __construct(Post $post, Phone $phone, User $user, SearchLog $searchLog)
    {
        $this->post = $post;
        $this->phone = $phone;
        $this->userModel = $user;
        $this->searchLog = $searchLog;
        $this->middleware('auth:api')->except([
            'doLogin', 'login', 'loginAdmin'
        ]);;
    }

    /**
     * Display welcome
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ['page' => 'Welcom phone by facebook id API power by Bui Nguyen'];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  array $request
     * @return \Illuminate\Http\Response
     */
    public function phone(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'id' => 'required',
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return ['status' => 0,
            'error' => $validator->errors()];
        }
        $uid = isset($data['id']) ? $data['id'] : null;
        if(!$uid) {
            return ['status' => 0, 'message' => 'Thiếu thông tin facebook id'];
        }
        if (!$phone = $this->phone->getPhoneByUid($uid))
            return ['status' => 0,'message' => 'Không tìm thấy số điện thoại'];
        $userId = Auth::guard('api')->user()->id;
        $oldLog = $this->searchLog->isExistHistories($uid, $userId);
        // if($oldLog) {
        //     $oldLog->phone = ''.$phone;
        //     $oldLog->fbName = $data['name'];
        //     $oldLog->url = isset($data['url']) ? $data['url'] : null;
        //     $oldLog->save();
        // } else {
        $log = SearchLog::updateOrCreate([
            'fbId' => $uid, 
            'userId' => $userId,
            'phone' => $phone,
            'fbName' => $data['name'],
            'url' => isset($data['url']) ? $data['url'] : null,
            'gender' => isset($data['gender']) ? $data['gender'] : 'male',
        ]);
    // }
        return ['status' => 1,'message' => 'Thành công',
            'data' => $phone];;
    }

    public function doLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|min:5',
        ]);
        if ($validator->fails()) {
            return ['status' => 0,
            'error' => $validator->errors()];
        }

        $data = $request->all();
        $user = $this->userModel->checkUserLogin($data, true);
        if (!$user) {
            return ['status' => 0,
            'message' => 'Thông tin đăng nhập không chính xác'];
        }
        if($user->status == 2) {
            return ['status' => 0,
            'message' => 'Tài khoản đang bị khóa '];
        }
        if($user->status == 0) {
            return ['status' => 0,
            'message' => 'Tài khoản chưa được kích hoạt'];
        }
        $user->api_token = hash('sha256', Str::random(60));
        if($user->save()) {

        return ['status' => 1,
                'data' => $user,
            'message' => 'Đăng nhập thành công'];
        } else {
            return ['status' => 0,
            'message' => 'Đã có lỗi xảy ra, vui lòng thử lại sau'];
        }
    }

    public function getHistories() {
        $id = Auth::guard('api')->id;
        $histories = $this->searchLog->searchHistories($id);
        return ['status' => 1,
                'data' => $histories,
            'message' => 'Lấy lịch sử thành công'];
    }

}
