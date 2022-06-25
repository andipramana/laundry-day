@extends('layouts.main')
@section('title')
    Dashboard
@endsection
@section('container')
    <div class="row">
        <div class="col-lg-6">
            @include('pages.dashboard.components.chartweekly')
            <!-- /.card -->
        </div>
        <!-- /.col-md-6 -->
        <div class="col-lg-6">
            @include('pages.dashboard.components.chartmonthly')
        </div>
    </div>
@endsection

@section('footerscript')
    <script src="{{ asset('template/plugins/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('template/dist/js/pages/dashboard3.js') }}"></script>
@endsection
