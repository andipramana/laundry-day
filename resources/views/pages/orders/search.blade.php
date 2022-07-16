@extends('layouts.main')
@section('headerscript')
    <link rel="stylesheet" href="{{ asset('template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('title')
    Search Orders
@endsection
@section('container')
    <div class="row mt-5 mb-3">
        <div class="col-3">
            <a href="/orders/register" class="btn btn-primary">Add Order</a>
        </div>
        <div class="col-3">
            <form class="d-flex" role="search" action="orders">
                <input class="form-control me-2" type="search" value="{{ $keywords }}" name="keywords" placeholder="Search" aria-label="Search">
                <button class="btn btn-primary" type="submit">Search</button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">List of Order</h3>
                </div>
                <div class="card-body">
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Code</th>
                                <th scope="col">Date</th>
                                <th scope="col">Weight</th>
                                <th scope="col">Laundry Type</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Customer Gender</th>
                                <th scope="col">Customer Phone No.</th>
                                <th scope="col">Cost</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $row)
                                <tr>
                                    <th>{{ $row->order_code }}</th>
                                    <th>{{ $row->created_at }}</th>
                                    <th>{{ $row->weight }}</th>
                                    <th>{{ $row->laundry_type }}</th>
                                    <th>{{ $row->customer_name }}</th>
                                    <th>{{ $row->customer_gender }}</th>
                                    <th>{{ $row->customer_phone_no }}</th>
                                    <th>{{ $row->cost }}</th>
                                    <th><span class="right badge badge-@include('pages.orders.components.badgestatusorder')">{{ $row->status }}</span></th>
                                    <th>
                                        @if ($row->status == 'Registered')
                                            <a href="/orders/process?code={{ $row->order_code }}&status=Washed" class="btn btn-warning">Wash</a>
                                        @elseif ($row->status == 'Washed')
                                            <a href="/orders/process?code={{ $row->order_code }}&status=Dried" class="btn btn-info">Drying</a>
                                        @elseif ($row->status == 'Dried')
                                            <a href="/orders/process?code={{ $row->order_code }}&status=Done" class="btn btn-success">Package</a>
                                        @else
                                            -
                                        @endif
                                    </th>
                                </tr>
                            @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
