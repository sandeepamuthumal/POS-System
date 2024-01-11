@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="form-head mb-3 d-flex flex-wrap align-items-center">
            @if (Session::get('pos_log_user_type') == 'Admin')
                <h2 class="font-w600 title mb-2 me-auto ">Welcome To Circuit Galaxy Electronics</h2>
            @else
                <h2 class="font-w600 title mb-2 me-auto ">Welcome To Circuit Galaxy Electronics</h2>
            @endif
        </div>
        <div class="row">
            <div class="col-xl-4 col-sm-6 m-t35">
                <a href="{{ route('all_customers') }}">
                    <div class="card card-coin">
                        <div class="card-body text-center">
                            <div class="icon-box">
                                <span class="bg-danger currency-icon mb-3" width="80" height="80">
                                    <i class="fa-solid fa-users fs-24 text-white"></i> </span>
                            </div>
                            <h2 class="text-black mb-2 font-w600">{{ $all_customers }}</h2>
                            <p class="mb-0 fs-14">
                                Customers
                            </p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-4 col-sm-6 m-t35">
                <a href="{{ route('products') }}">
                    <div class="card card-coin">
                        <div class="card-body text-center">
                            <div class="icon-box">
                                <span class="bg-green currency-icon mb-3">

                                    <i class="fa fa-cube  fs-24 text-white"></i></span>
                            </div>
                            <h2 class="text-black mb-2 font-w600">{{ $all_products }}</h2>
                            <p class="mb-0 fs-13">
                                Products
                            </p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-4 col-sm-6 m-t35">
                <a href="{{ route('products') }}">
                    <div class="card card-coin">
                        <div class="card-body text-center">
                            <div class="icon-box">
                                <span class="bg-success currency-icon mb-3">

                                    <i class="fa fa-usd  fs-24 text-white"></i> </span>
                            </div>
                            <h2 class="text-black mb-2 font-w600"> {{ $all_sales }} </h2>
                            <p class="mb-0 fs-14">
                                Sales
                            </p>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="row">
            @foreach ($products as $item)
                <div class="col-xl-3 col-xxl-3 col-lg-3 col-md-6 col-sm-6 items site-list-area">
                    <div class="card contact-bx item-content">
                        <div class="new-arrival-product mb-4 mb-xxl-4 mb-md-0">
                            <div class="new-arrivals-img-contnent">
                                <div class="cardImgcontainer"
                                    style="background: url('{{ asset('uploads/products/' . $item->image) }}')">
                                    <img class="cardImg" src="{{ asset('uploads/products/' . $item->image) }}"
                                        title="{{ $item->site_name }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('css')
    <style>
        .icon-box {
            margin-top: -30px;
        }

        .icon-box span {
            width: 60px;
            display: inline-table;
            height: 60px;
        }

        .icon-box i {

            margin-top: 14px;

        }
    </style>
@endpush
