<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel='stylesheet' id='bootstrap-css' href='{{url('assets/css/bootstrap.css')}}' type='text/css' media='all'/>
    <link rel='stylesheet' id='bootstrap-rtl-css' href='{{url('assets/css/bootstrap-rtl.css')}}' type='text/css'
          media='all'/>
    <link rel='stylesheet' id='font-awesome-css' href='{{url('assets/css/line-awesome.css')}}' type='text/css'
          media='all'/>
    <link rel='stylesheet' id='style-css' href='{{url('style.css')}}' type='text/css' media='all'/>

</head>
<body >
<div class="container-fluid @if($have_package) body-not-package @endif p-0">
    <div class="row no-gutters">
        <div class="col-2">
            <div class="account-sidebar p-1">
                <div class="user-sidebar my-4 text-center">
                    <img src="https://www.gravatar.com/avatar/{{md5(auth()->user()->email)}}"/>
                    <h3>{{auth()->user()->name}}</h3>
                    <div class="row">
                        <div class="col-6 text-right"><span class="p-1 small">اعتبار: {{auth()->user()->send_limit}} پیامک</span>
                        </div>
                        <div class="col-6 text-left"><span class="p-1 small">{{jdate(strtotime($finish_at))->ago()}} مانده</span></div>
                    </div>
                </div>
                <ul>
                    <li>
                        <a class="active" href="{{url()->route('auth-index')}}">
                            <i class="la la-dashboard"></i>
                            پیشخوان
                        </a>
                    </li>
                    <li>
                        <a class="" href="{{url()->route('people-index')}}">
                            <i class="la la-user"></i>
                            مخاطب ها
                        </a>
                    </li>
                    <li>
                        <a class="" href="{{url()->route('event-index')}}">
                            <i class="la la-comments"></i>
                            رویداد ها
                        </a>
                    </li>

                    <li>
                        <a class="" href="#">
                            <i class="la la-credit-card"></i>
                            اعتبار
                        </a>
                    </li>
                    <li>
                        <a class="" href="#">
                            <i class="la la-gear"></i>
                            تنظیمات
                        </a>
                    </li>
                    <li>
                        <a class="" href="{{url('/logout')}}">
                            <i class="la la-sign-out"></i>
                            خروج
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-10">
            <div class="header-account mb-3">
                <div class="menu-header">
                    <ul>
                        <li>
                            <a href="#">شارژ حساب</a>
                        </li>
                        <li>
                            <a href="#">ارسال تیکت</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="box-account-pages shadow-sm">
                <div class="title-account mb-3">
                    <h1>@yield('title') @yield('btn-head')</h1>
                    <h4>@yield('description')</h4>
                </div>
                <div class="body-account">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</div>
@if($have_package)
    <div class="not-package">
       <div class="text-sec">
           <h1>زمان پکیج شما به اتمام رسیده است</h1>
           <a class="btn-not-pack" href="{{url('/')}}">خرید پکیج جدید</a>
           <a class="btn-not-pack btn-not-pack-logout" href="{{url('/logout')}}">خروج</a>
       </div>
    </div>
@endif
</body>
</html>