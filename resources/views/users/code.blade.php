@extends('layouts.app')

@section('title', "Admin code")

@section('content')

<h3>Admin Code hiện tại là <b style="color:#e3342f">{{ $adminCode }}</b></h3>

<form action="{{ route('users.resetCode') }}" method="post">
    @csrf
    <input type="hidden" name="_method" value="POST">
    <button type="submit" class="btn btn-danger">Khởi tạo lại Admin Code</button>
</form>

@endsection