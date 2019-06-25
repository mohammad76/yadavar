@extends('layouts.master-auth')

@section('title' , 'افزودن مخاطب')
@section('description' , 'در اینجا می توانید مخاطب جدید ایجاد کنید')

@section('content')

    <form class="form-people" method="post" action="{{url()->route('people-store')}}">
        @csrf
        <div class="form-row">
            <div class="form-group col-12 col-md-4">
                <label for="name">نام و نام خانوادگی:</label>
                <input type="text" name="name" class="form-control" id="name">
            </div>
            <div class="form-group col-12 col-md-4">
                <label for="mobile">موبایل:</label>
                <input type="number" name="mobile" class="form-control" id="mobile">
            </div>
            <div class="form-group col-12 col-md-4">
                <label for="email">ایمیل:</label>
                <input type="email" name="email" class="form-control" id="email">
            </div>
        </div>
        <div class="form-group">
            <input type="submit" id="submit" class="btn btn-primary" value="ثبت مخاطب">
        </div>
    </form>


@endsection