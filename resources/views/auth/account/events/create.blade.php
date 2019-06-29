@extends('layouts.master-auth')

@section('title' , 'افزودن رویداد')
@section('description' , 'در اینجا می توانید رویداد جدید ایجاد کنید')

@section('content')

    <form class="form-people" method="post" action="{{url()->route('event-store')}}">
        @csrf

        <div class="person-box">
            <div class="row">
                <div class="col-12">
                    <h3>مخاطب
                        <span style="cursor: pointer;" class="btn btn-secondary btn-sm mt-1 btn-add-person">افزودن سریع مخاطب</span>
                    </h3>
                </div>
            </div>
            <div class="form-row person-section">
                <div class="col-12 select-person">
                    <div class="row">
                        <div class="form-group col-12 col-md-6">
                            <label for="name">انتخاب مخاطب:</label>
                            <select class="form-control" name="person_id">
                                <option value="">لطفا یک مخاطب را انتخاب کنید</option>
                                @foreach($people as $person)
                                    <option value="{{$person->id}}">{{$person->name}}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>
                <div class="col-12 create-person" style="display: none">
                    <div class="form-row">
                        <div class="form-group col-12 col-md-4">
                            <label for="person_name">نام و نام خانوادگی:</label>
                            <input type="text" name="person_name" class="form-control" id="person_name">
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <label for="person_mobile">موبایل:</label>
                            <input type="number" name="person_mobile" class="form-control" id="person_mobile">
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <label for="person_email">ایمیل:</label>
                            <input type="email" name="person_email" class="form-control" id="person_email">
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <fieldset>
            <legend>اطلاعات اصلی:</legend>
            <div class="form-row">
                <div class="form-group col-12 col-md-6">
                    <label for="name">نام رویداد:</label>
                    <input type="text" name="name" class="form-control" placeholder="تولد، سالگرد و ..." id="name">
                </div>
                <div class="form-group col-12 col-md-6">
                    <label for="event_type">نوع رویداد:</label>
                    <select class="form-control" name="type" id="event_type">
                        <option value="yearly">سالانه</option>
                        <option value="monthly">ماهانه</option>
                        <option value="daily">روزانه</option>
                        <option value="hourly">ساعتی</option>
                        <option value="exact">دقیق</option>
                    </select>
                </div>

            </div>
            <div class="form-row type-sections yearly-section">
                <div class="form-group col-12 col-md-6">
                    <label for="yearly_period">دوره رویداد:</label>
                    <select class="form-control" name="yearly_period" id="yearly_period">
                        <option value="1">هر سال</option>
                        <option value="2">هر 2 سال</option>
                        <option value="3">هر 3 سال</option>
                        <option value="4">هر 4 سال</option>
                        <option value="5">هر 5 سال</option>
                    </select>
                </div>
                <div class="form-group col-4 col-md-1">
                    <label for="yearly_day">روز:</label>
                    <select class="form-control" name="yearly_day" id="yearly_day">
                        @for($i=1 ; $i<32 ; $i++)
                            <option value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>
                </div>
                <div class="form-group col-4 col-md-1">
                    <label for="yearly_month">ماه:</label>
                    <select class="form-control" name="yearly_month" id="yearly_month">
                        @for($i=1 ; $i<13 ; $i++)
                        <option value="{{$i}}">{{$i}}</option>

                        @endfor
                    </select>
                </div>
            </div>
            <div class="form-row type-sections monthly-section">
                <div class="form-group col-12 col-md-6">
                    <label for="monthly_period">دوره رویداد:</label>
                    <select class="form-control" name="monthly_period" id="monthly_period">
                        <option value="1">هر ماه</option>
                        <option value="2">هر 2 ماه</option>
                        <option value="3">هر 3 ماه</option>
                        <option value="4">هر 4 ماه</option>
                        <option value="5">هر 5 ماه</option>
                    </select>
                </div>
                <div class="form-group col-4 col-md-1">
                    <label for="monthly_day">روز:</label>
                    <select class="form-control" name="monthly_day" id="monthly_day">
                        @for($i=1 ; $i<32 ; $i++)
                            <option value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="form-row type-sections daily-section">
                <div class="form-group col-12 col-md-6">
                    <label for="daily_period">دوره رویداد:</label>
                    <select class="form-control" name="daily_period[]" multiple>
                        <option value="8" selected>هر روز</option>
                        <option value="0">شنبه</option>
                        <option value="1">یکشنبه</option>
                        <option value="2">دوشنبه</option>
                        <option value="3">سه شنبه</option>
                        <option value="4">چهارشنبه</option>
                        <option value="5">پنج شنبه</option>
                        <option value="6">جمعه</option>
                    </select>
                </div>
                <div class="form-group col-4 col-md-4">
                    <label for="name">ساعت:</label>
                    <select class="form-control" name="daily_hour">
                        @for($i=1 ; $i<25 ; $i++)
                            <option value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="form-row type-sections hourly-section">
                <div class="form-group col-12 col-md-6">
                    <label for="name">دوره رویداد:</label>
                    <select class="form-control" name="period">
                        <option value="1">هر 1 ساعت</option>
                        <option value="1">هر 2 ساعت</option>
                        <option value="1">هر 3 ساعت</option>
                        <option value="1">هر 4 ساعت</option>
                        <option value="1">هر 5 ساعت</option>
                        <option value="1">هر 6 ساعت</option>
                        <option value="1">هر 7 ساعت</option>
                        <option value="1">هر 8 ساعت</option>
                        <option value="1">هر 9 ساعت</option>
                        <option value="1">هر 10 ساعت</option>
                        <option value="1">هر 11 ساعت</option>
                        <option value="1">هر 12 ساعت</option>
                        <option value="1">هر 13 ساعت</option>
                        <option value="1">هر 14 ساعت</option>
                        <option value="1">هر 15 ساعت</option>
                        <option value="1">هر 16 ساعت</option>
                        <option value="1">هر 17 ساعت</option>
                        <option value="1">هر 18 ساعت</option>
                        <option value="1">هر 19 ساعت</option>
                        <option value="1">هر 20 ساعت</option>
                    </select>
                </div>
            </div>
            <div class="form-row type-sections exact-section">
                <div class="form-group col-12 col-md-6">
                    <label for="name">تاریخ:</label>
                    <input type="date" class="form-control">
                </div>
            </div>

        </fieldset>
        <fieldset>
            <legend>پیامک:</legend>
            <div class="form-row">
                <div class="form-group col-12">
                    <input type="checkbox" name="send-sms" id="send-sms">
                    <label class="form-check-label" for="send-sms">آیا مایل به ارسال پیامک به این مخاطب هستید ؟</label>
                </div>
                <div class="form-group sms-text col-12 col-md-12" style="display:none;">
                    <label for="name">متن پیامک:</label>
                    <textarea rows="4" class="form-control" name="sms-text"></textarea>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend>یادآوری:</legend>
            <div class="form-row">
                <div class="form-group col-12 col-md-6" id="remind_day_section">
                    <label for="name">زمان یادآوری:</label>
                    <select class="form-control" name="remind_day" id="remind_day">
                        <option value="0">همان روز</option>
                        <option value="1">1 روز قبل</option>
                        <option value="2">2 روز قبل</option>
                        <option value="3">3 روز قبل</option>
                        <option value="4">4 روز قبل</option>
                        <option value="5">5 روز قبل</option>
                        <option value="6">6 روز قبل</option>
                        <option value="7">7 روز قبل</option>
                        <option value="8">8 روز قبل</option>
                        <option value="9">9 روز قبل</option>
                    </select>
                </div>
                <div class="form-group col-12 col-md-6" id="remind_time_section">
                    <label for="name">ساعت یادآوری:</label>
                    <select class="form-control" name="remind_time" id="remind_time">
                        <option value="0">صبح</option>
                        <option value="1">ظهر</option>
                        <option value="2">شب</option>
                    </select>
                </div>
                <div class="form-group col-12 col-md-12">
                    <label for="name">توضیحات یادآوری:</label>
                    <textarea rows="4" class="form-control"
                              placeholder="یک توضیح در مورد رویداد که در حال ثبت آن می باشید."></textarea>
                </div>
            </div>
        </fieldset>
        <div class="form-group">
            <input type="submit" id="submit" class="btn btn-primary" value="ثبت رویداد">
        </div>
    </form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        $('.type-sections').slideUp();
        $('.yearly-section').slideDown();
        $('body').on('click', '.btn-add-person', function (e) {
            $('.select-person').slideUp();
            $('.create-person').slideDown();
            $(this).text('انتخاب مخاطب');
            $(this).removeClass('btn-add-person');
            $(this).addClass('btn-create-person');
        });

        $('body').on('click', '.btn-create-person', function (e) {
            $('.create-person').slideUp();
            $('.select-person').slideDown();
            $(this).text('افزودن سریع مخاطب');
            $(this).removeClass('btn-create-person');
            $(this).addClass('btn-add-person');
        });

        $('#event_type').change(function (e) {
            $('.type-sections').slideUp();
            $('.' + this.value + '-section').slideDown();
            if(this.value == 'daily' || this.value == 'hourly'){
                $('#remind_day_section').slideUp();
                $('#remind_time_section').slideUp();
            }else {
                $('#remind_day_section').slideDown();
                $('#remind_time_section').slideDown();
            }
        });

        $('#send-sms').change(function () {
            if (this.checked) {
                $('.sms-text').slideDown();
            } else {
                $('.sms-text').slideUp();
            }

        });
    </script>
@endsection