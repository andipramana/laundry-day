@extends('layouts.main')
@section('title')
    Register Order
@endsection
@section('container')
    <h1 class="text-center mb-4">Register Order</h1>
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card">
                <div class="card-body">
                    <form method="post">
                        @csrf
                        <div class="form-group">
                            <label for="weight">Weight</label>
                            <input type="number" min="1" class="form-control" id="weight" name="weight" placeholder="Input weight in kg...">
                        </div>
                        <div class="form-group">
                            <label for="laundryType">Laundry Type</label>
                            <select class="form-select" name="laundry_type">
                                <option>-- Select --</option>
                                <option value="regular">Regular</option>
                                <option value="priority">Priority</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="customerName">Customer Name</label>
                            <input type="text" class="form-control" id="customerName" name="customer_name" placeholder="Input customer name...">
                        </div>
                        <div class="form-group">
                            <label for="customerGender">Customer Gender</label>
                            <select class="form-select" name="customer_gender">
                                <option>-- Select --</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="customerPhoneNo">Customer Phone No</label>
                            <input type="number" class="form-control" id="customerPhoneNo" name="customer_phone_no" placeholder="Input customer phone no...">
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
