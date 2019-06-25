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
<body>
@includeWhen(Route::currentRouteName() == 'index' ,'partials.main-header')
@includeWhen(Route::currentRouteName() != 'index' ,'partials.inner-header')
@yield('content')
<footer class="main-footer">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <p>تمام حقوق مادی و معنوی این سایت متعلق به مجموعه کاپرینا می باشد و ضمنا خدمات یادآور فقط از طریق
                    وبسایت yadavar.ir صورت می گیرد.</p>
            </div>
        </div>
    </div>
</footer>
</body>
</html>