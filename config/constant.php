<?php
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 1/3/2018
 * Time: 11:28 PM
 */

return [
    'APP_WEB_ASSET_URL' => env('APP_WEB_ASSET_URL', '/website'),
    'APP_WEB_FILE_URL' => env('APP_WEB_FILE_URL', '/file'),
    'APP_FINI_WEB_ASSET_URL' => env('APP_FINI_WEB_ASSET_URL', '/fini_assets'),
    'APP_KUTE_WEB_ASSET_URL' => env('APP_KUTE_WEB_ASSET_URL', '/kute_assets'),
    'APP_ADMIN_ASSET_URL' => env('APP_ADMIN_ASSET_URL', '/admin'),
    'DATETIME_FORMAT' => 'Y-m-d H:i:s',
    'DATE_FORMAT' => 'Y-m-d',
    'VIEW_DATE_FORMAT' => 'd/m/Y',
    'SPLIT_CHARACTER' => '|||',
    'VALIDATOR_MESSAGE' => [
        'name.required' => 'Tên không được bỏ trống.',
        'phone_number.required' => 'Số điện thoại không được bỏ trống.',
        'password.required' => 'Mật khẩu không được bỏ trống.',
        'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
        'address.required' => 'Địa chỉ không được bỏ trống.',
        'phone_number.unique' => "Số điện thoại đã dùng để đăng ký tài khoản khác.",
        'phone_number.regex' => "Số điện thoại không đúng định dạng 084xxx, 09xxx, 012xxx.",
        'email.email' => "Địa chỉ email không đúng định dạng.",
        'phone_number_refer.regex' => "Số điện thoại của người giới thiệu không đúng.",
        'product_code.required' => 'Mã sản phẩm không được bỏ trống',
        'id.numeric' => 'ID phải là số',
        'id.required' => 'ID không được bỏ trống',
        'order_status.numeric' => 'order_status phải là số',
        'order_status.required' => 'order_status không bỏ trống',
        'shop_code.required' => 'Mã cửa hàng không được bỏ trống'
    ],
    'ORDER_CODE_LENGTH' => 6,
    'MAX_LIMIT_PER_PAGE' => 50,
    'STATUS_CANCEL' => -1,
    'STATUS_WAITING' => 0,
    'STATUS_ZIPPED' => 1,
    'STATUS_SHIPPING' => 2,
    'STATUS_FINISH' => 3,
    'IMAGE_MIME_TYPE_ALLOWED' => ['image/png', 'image/jpeg'],
    'MAX_SIZE_UPLOAD_FILE' => 4096000,   // calculate in byte
    'FUNCTION_SUCCESS_CODE' => 1,
    'FUNCTION_ERROR_CODE' => 0,
    'RANDOM_NAME_FILE_LENGTH' => 6,
    'PRODUCT_WIDTH_SIZE' => 570,
    'PRODUCT_THUMBNAIL_WIDTH_SIZE' => 200,
    'CATEGORY_IMG_WIDTH_SIZE' => 32,
    'WEBSITE_DOMAIN' => env('WEBSITE_DOMAIN', 'fini.vn'),
    'NUMBER_RANDOM_PRODUCT' => 6,
];
