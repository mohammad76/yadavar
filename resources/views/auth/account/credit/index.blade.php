@extends('layouts.master-auth')

@section('title' , 'اعتبار')
@section('description' , 'در اینجا می توانید اعتبار خود را افزایش دهید')

@section('content')
    <div class="alert alert-info">
        <h5>اعتبار حساب شما {{auth()->user()->send_limit}} پیامک می باشد.</h5>
    </div>

    <form method="post" action="{{url()->route('credit-pay')}}">
        @csrf
        <div class="form-group">
            <label for="credit">میزان شارژ:</label>
            <input type="number" name="credit" class="form-control" id="credit">
        </div>
        <h4>مبلغ قابل پرداخت: <span id="pay-amount">0</span></h4>
        <div class="form-group">
            <input type="submit" id="submit" class="btn btn-primary" value="شارژ حساب">
        </div>
    </form>
@endsection
@section('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        $('#credit').on('input' ,function () {
            var val = $(this).val() * 120;
            $('#pay-amount').text(val);
        });
        </script>

@endsection