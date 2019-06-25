@extends('layouts.master-auth')

@section('title' , 'مخاطب ها')
@section('description' , 'در اینجا می توانید افراد را ببینید')
@section('btn-head')
    <a class="btn btn-secondary btn-sm" href="{{url()->route('people-create')}}">افزودن فرد</a>
@endsection
@section('content')

    <table class="table table-bordered">
        <tr>
            <th>#</th>
            <th>نام و نام خانوادگی</th>
            <th>موبایل</th>
            <th>اکشن</th>
        </tr>
        @foreach($people as $person)
            <tr>
                <td>
                    {{$person->id}}
                </td>
                <td>
                    {{$person->name}}
                </td>
                <td>
                    {{$person->mobile}}
                </td>
                <td>
                    <a href="{{url()->route('people-edit' , ['id' => $person->id])}}" class="btn btn-primary btn-sm">ویرایش</a>
                    <a href="{{url()->route('people-destroy' , ['id' => $person->id])}}" class="btn btn-danger btn-sm">حذف</a>
                </td>
            </tr>
        @endforeach
    </table>

@endsection