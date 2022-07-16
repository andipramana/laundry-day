@extends('layouts.main')
@section('headerscript')
    <link rel="stylesheet" href="{{ asset('template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('title')
    Search Employee
@endsection
@section('container')
    <div class="row mt-5 mb-3">
        <div class="col-3">
            <a href="/employees/register" class="btn btn-primary">Add Employee</a>
        </div>
        <div class="col-3">
            <form class="d-flex" role="search" action="employees">
                <input class="form-control me-2" value="{{ $keywords }}" type="search" name="keywords" placeholder="Search" aria-label="Search">
                <button class="btn btn-primary" type="submit">Search</button>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">List of Employee</h3>
                </div>
                <div class="card-body">
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Code</th>
                                <th scope="col">Name</th>
                                <th scope="col">Gender</th>
                                <th scope="col">Phone No</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $row)
                                <tr>
                                    <th>{{ $row->employee_code }}</th>
                                    <th>{{ $row->name }}</th>
                                    <th>{{ $row->gender }}</th>
                                    <th>{{ $row->phone_no }}</th>
                                    <th>
                                        <a href="/employees/modify/{{ $row->id }}" class="btn btn-warning">Modify</a>
                                        <a href="/employees/delete/{{ $row->id }}" class="btn btn-danger">Delete</a>
                                    </th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
