@extends('layouts.master-auth')

@section('title' , 'افزودن مخاطب')
@section('description' , 'در اینجا می توانید مخاطب جدید ایجاد کنید')

@section('content')

    <form method="post" action="{{url()->route('people-update' , ['id' => $person->id])}}">
        @csrf
        <div class="form-row">
            <div class="form-group col-12 col-md-6">
                <label for="name">نام و نام خانوادگی:</label>
                <input type="text" name="name" value="{{$person->name}}" class="form-control" id="name">
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="mobile">موبایل:</label>
                <input type="number" name="mobile" value="{{$person->mobile}}" class="form-control" id="mobile">
            </div>
            <div class="form-group col-12">
                <input type="submit" class="btn btn-primary" value="ثبت مخاطب">
            </div>
        </div>
    </form>

@endsection