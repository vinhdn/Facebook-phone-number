@extends('layouts.app')
@section('content')
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE BAR -->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <span>Quản lý danh sách thành viên</span>
                </li>
            </ul>
        </div>
        <!-- END PAGE BAR -->

        <!-- TABLE USER DATA -->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-user"></i>Danh sách thành viên</div>
                        <div class="tools"> </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="lst-usr-tbl" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th class="all">Id</th>
                                <th class="min-tablet">Tên thành viên</th>
                                <th class="desktop">Email</th>
                                <th class="desktop">Trạng thái</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($listUser as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>
                                        <a>
                                            {{ $user->name }}
                                        </a>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>@if($user->status == \App\Models\User::STATUS_NOT_CONFIRM)
                                            Chưa xác nhận tài khoản
                                        @elseif($user->status == \App\Models\User::STATUS_ACTIVE)
                                            Đang kích hoạt
                                        @elseif($user->status == \App\Models\User::STATUS_DEACTIVATE)
                                            Đang tạm khóa
                                        @else
                                            Không xác định
                                        @endif</td>
                                        <td><div class="btn-group pull-right">
                                            <a href="{{ route('users.updateStatus', ['id' => $user->id, 'status' => ($user->status + 1)]) }}" class="btn green btn-xs">
                                            @if($user->status == \App\Models\User::STATUS_NOT_CONFIRM)
                                            Kích hoạt
                                        @elseif($user->status == \App\Models\User::STATUS_ACTIVE)
                                            Khóa
                                        @elseif($user->status == \App\Models\User::STATUS_DEACTIVATE)
                                            Hủy Khóa
                                        @else
                                            
                                        @endif
                                            </a>
                                        </div></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
        <!-- END TABLE LICENSE DATA -->
    </div>
</div>

@endsection