@extends('layouts.main')
@section('title')
    Modify Employee
@endsection
@section('container')
    <h1 class="text-center mb-4">Modify Employee</h1>
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="/employees/modify">
                        @csrf
                        <input type="hidden" class="form-control" id="id" name="id" value="{{ $employee->id }}">
                        <input type="hidden" class="form-control" id="employee_code" name="employee_code" value="{{ $employee->employee_code }}">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Input name..." value="{{ $employee->name }}">
                        </div>
                        <div class="form-group">
                            <label for="phoneNo">Phone No</label>
                            <input type="number" class="form-control" id="phone_no" name="phone_no" placeholder="Input phone no..." value="{{ $employee->phone_no }}">
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select class="form-control" name="gender">
                                <option>-- Select --</option>
                                <option value="male" {{ $employee->gender == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ $employee->gender == 'female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Modify</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
