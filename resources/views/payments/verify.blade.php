@extends('layouts.master')

@section('content')
    <div class="pages-section">
        <div class="box-title-page bg-silver py-4 mb-5">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <h1>وضعیت پرداخت</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="container ">
            <div class="row">
                <div class="col-12">
                    @if($code == 400)
                        <div class="alert alert-danger line-height-30">
                            <p>مشکل در پرداخت</p>
                            <p>درصورتی که پول از حساب شما کم شده باشد. پول تا 72 ساعت دیگر به حساب شما بر خواهد گشت. در
                                غیر
                                این صورت با شماره 09352864812 تماس حاصل فرمایید.</p>
                            <p>{{$exception->getMessage()}}</p>
                        </div>
                    @elseif($code == 200)
                        <div class="alert alert-success line-height-30">
                            <p>پرداخت با موفقیت انجام شد</p>
                            <p>شماره پیگیری: {{$transaction_id}}</p>
                            <p>در حال انتقال به حساب کاربری ...</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection