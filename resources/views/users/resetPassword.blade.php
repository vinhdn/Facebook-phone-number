@extends('layouts.app')

@section('title', "Thay đổi mật khẩu")

@section('content')

<h3>Thay đổi mật khẩu cho user <b style="color:#e3342f">{{ $user->email }}</b></h3>

<form action="{{ route('users.resetPassword') }}" method="post">
    @csrf
    <input type="hidden" name="_method" value="POST">
    <input type="hidden" name="id" value="{{ $user->id }}">
    <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <button type="submit" class="btn btn-danger">Thay đổi</button>
</form>

@endsection