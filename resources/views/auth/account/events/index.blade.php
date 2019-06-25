@extends('layouts.master-auth')

@section('title' , 'رویداد ها')
@section('description' , 'در اینجا می توانید رویداد ها را ببینید')
@section('btn-head')
    <a class="btn btn-secondary btn-sm" href="{{url()->route('event-create')}}">افزودن رویداد</a>
@endsection
@section('content')

    <table class="table table-bordered">
        <tr>
            <th>#</th>
            <th>نام مخاطب</th>
            <th>نام رویداد</th>
            <th>تاریخ رویداد</th>
            <th>اکشن</th>
        </tr>
        @foreach($events as $event)
            @php
                $date = explode('-' , $event->date );

                $now_year = date('Y');
                   if($date[1] <= date('m')){
                        $now_year += 1;
                   }
            $date = "$now_year-$date[1]-$date[2]"
            @endphp
            <tr>
                <td>
                    {{$event->id}}
                </td>
                <td>
                    {{$event->person->name}}
                </td>
                <td>
                    {{$event->name}}
                </td>
                <td>
                    {{jdate($date)->format('%A, %d %B %y')}} ({{jdate($date)->ago()}} مانده)
                </td>
                <td>
                    <a href="{{url()->route('event-edit' , ['id' => $event->id])}}" class="btn btn-primary btn-sm">ویرایش</a>
                    <a href="{{url()->route('event-destroy' , ['id' => $event->id])}}"
                       class="btn btn-danger btn-sm">حذف</a>
                </td>
            </tr>
        @endforeach
    </table>

@endsection