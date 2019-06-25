@extends('layouts.master')

@section('content')
    <div class="pages-section">
        <div class="box-title-page bg-silver py-4 mb-5">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <h1>مشخصات سفارش</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="card shadow-sm my-3">
                        <div class="card-body">
                           <div class="row">
                               <div class="col-3 text-center">
                                   <div class="h4">{{$package->name}}</div>
                               </div>
                               <div class="col-9">
                                   {{$package->body}}
                               </div>
                           </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="box-pay shadow-sm">
                        <div class="title-pay">
                            صورتحساب
                        </div>
                        <div class="body-pay">
                            <ul>
                                <li>
                                    <p>تاریخ صورت حساب: 22/11/2019</p>
                                </li>
                                <li>
                                    <p>پکیج: {{$package->name}}</p>
                                </li>
                            </ul>
                            <div class="h1 price">{{$package->price}} <span class="small">تومان</span></div>
                        </div>
                        <a href="{{url('/pay/'.$package->id)}}" class="btn-pay">
                            پرداخت صورت حساب
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection