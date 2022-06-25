@extends('layouts.main')
@section('title')
    Search Orders
@endsection
@section('container')
    <div class="row mt-5 mb-3">
        <div class="col-3">
            <a href="/orders/register" class="btn btn-primary">Add Order</a>
        </div>
        <div class="col-3">
            <form class="d-flex" role="search" action="searchorder">
                <input class="form-control me-2" type="search" name="keyword" placeholder="Search" aria-label="Search">
                <button class="btn btn-primary" type="submit">Search</button>
            </form>
        </div>
    </div>
    <div class="row">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Code</th>
                    <th scope="col">Date</th>
                    <th scope="col">Weight</th>
                    <th scope="col">Laundry Type</th>
                    <th scope="col">Customer Name</th>
                    <th scope="col">Customer Gender</th>
                    <th scope="col">Customer Phone No.</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $row)
                    <tr>
                        <th>{{ $row->order_code }}</th>
                        <th>{{ $row->date }}</th>
                        <th>{{ $row->weight }}</th>
                        <th>{{ $row->laundry_type }}</th>
                        <th>{{ $row->customer_name }}</th>
                        <th>{{ $row->customer_gender }}</th>
                        <th>{{ $row->customer_phone_no }}</th>
                        <th>{{ $row->status }}</th>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
