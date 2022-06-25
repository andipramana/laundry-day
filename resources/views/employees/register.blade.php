@extends('layouts.main')
@section('title')
    Register Employee
@endsection
@section('container')
    <h1 class="text-center mb-4">Register Employee</h1>
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card">
                <div class="card-body">
                    <form method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Input name...">
                        </div>
                        <div class="form-group">
                            <label for="phoneNo">Phone No</label>
                            <input type="text" class="form-control" id="phone_no" name="phone_no" placeholder="Input phone no...">
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select class="form-control" name="gender">
                                <option>-- Select --</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
