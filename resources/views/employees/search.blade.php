@extends('layouts.main')
@section('title')
    Search Employee
@endsection
@section('container')
    <div class="row mt-5 mb-3">
        <div class="col-3">
            <a href="/employees/register" class="btn btn-primary">Add Employee</a>
        </div>
        <div class="col-3">
            <form class="d-flex" role="search" action="searchemployee">
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
                    <th scope="col">Name</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Phone No</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $row)
                    <tr>
                        <th>{{ $row->name }}</th>
                        <th>{{ $row->employee_code }}</th>
                        <th>{{ $row->gender }}</th>
                        <th>{{ $row->phone_no }}</th>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
