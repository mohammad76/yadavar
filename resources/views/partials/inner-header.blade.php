<div class="header-section header-inner">
    <div class="container">
        <div class="row">
            <div class="col-2">
                <div class="h1 mt-2">
                    یادآور
                </div>
            </div>
            <div class="col-7">
                <div class="main-menu">
                    <ul>
                        <li>
                            <a href="{{url('/')}}">صفحه اصلی</a>
                        </li>
                        <li>
                            <a href="#">تعرفه ها</a>
                        </li>
                        <li>
                            <a href="#">درباره ما</a>
                        </li>
                        <li>
                            <a href="#">تماس با ما</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-3 text-left">
                @guest
                    <a href="{{url('/my-account')}}" class="btn-login">
                        <i class="la la-sign-in"></i>
                        ورود / عضویت
                    </a>
                @endguest
                @auth
                        <a href="{{url('/logout')}}" class="float-left btn-login">
                            <i class="la la-sign-out"></i>
                            خروج
                        </a>
                        <a href="{{url('/my-account')}}" class="float-left ml-3 btn-login">
                            <i class="la la-user"></i>
                            حساب کاربری
                        </a>

                @endauth
            </div>
        </div>

    </div>
</div>
