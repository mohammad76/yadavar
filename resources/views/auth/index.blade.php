@extends('layouts.master')

@section('content')
    <div class="pages-section">
        <div class="box-title-page bg-silver py-4 mb-5">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <h1>ورود/عضویت</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            {{--        <div class="row">--}}
            {{--            <div class="col-12">--}}
            {{--                <p>پکیج انتخابی شما {{$package->name}}</p>--}}
            {{--            </div>--}}
            {{--        </div>--}}
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="card shadow-sm my-3">
                        <div class="card-body">
                            <h3 class="card-title text-primary">ثبت نام</h3>
                            <form method="post" action="{{url()->route('auth-register')}}">
                                @csrf
                                <input type="hidden" name="to" value="{{$to}}">
                                <div class="form-group">
                                    <label for="register-name">نام و نام خانوادگی:</label>
                                    <input name="name" id="register-name" type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="register-email">ایمیل:</label>
                                    <input name="email" id="register-email" type="email" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="register-mobile">شماره تماس:</label>
                                    <input name="mobile" id="register-mobile" type="number" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="register-password">رمز عبور:</label>
                                    <input name="password" id="register-password" type="password" class="form-control">
                                </div>
                                <input type="submit" class="btn btn-gradient" value="عضویت در سایت">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="card shadow-sm my-3">
                        <div class="card-body">
                            <h3 class="card-title text-primary">ورود به سایت</h3>
                            <form  method="post" action="{{url()->route('auth-login')}}">
                                @csrf
                                <input type="hidden" name="to" value="{{$to}}">
                                <div class="form-group">
                                    <label for="login-mobile">شماره موبایل:</label>
                                    <input name="mobile" id="login-mobile" type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="login-password">رمز عبور:</label>
                                    <input name="password" id="login-password" type="password" class="form-control">
                                </div>
                                <input type="submit" class="btn btn-gradient" value="ورود به سایت">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection