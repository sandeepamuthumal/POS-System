@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>{{ $product->item_name }}</h4>
                    <p class="mb-0">{{ $product->item_code }}</p>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('products') }}">Products</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ $product->item_code }}</a></li>
                </ol>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3">
                        <img class="img-fluid" src="{{ asset('uploads/qrcodes/' . $product->path) }}" alt="">
                    </div>
                    <div class="col-lg-6">
                        <div class="row mb-3">
                            <span class="col-lg-4">Product Name : </span>
                            <span class="col-lg-6 text-black">{{ $product->item_name }}</span>
                        </div>
                        <div class="row mb-3">
                            <span class="col-lg-4">Product Code : </span>
                            <span class="col-lg-6 text-black">{{ $product->item_code }}</span>
                        </div>
                        <div class="row mb-3">
                            <span class="col-lg-4">Description : </span>
                            <span class="col-lg-6 text-black">{{ $product->description }}</span>
                        </div>
                        <div class="row mb-3">
                            <span class="col-lg-4">Available Quantity : </span>
                            <span class="col-lg-6 text-black">{{ $product->available_stock }}</span>
                        </div>
                        <div class="row mb-3">
                            <span class="col-lg-4">Unit Price : </span>
                            <span class="col-lg-6 text-black">{{ $product->unit_price }}</span>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <img class="img-fluid" src="{{ asset('uploads/products/' . $product->image) }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
