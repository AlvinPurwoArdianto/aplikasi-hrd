@extends('layouts.user.template')
@section('content')
    <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row mt-4">
                <div class="col-lg-4 mb-lg-0 mb-4">
                    <div class="card z-index-2 h-100">
                        <div class="card-header pb-0 pt-3 bg-transparent">
                            <h6 class="text-capitalize">Sales overview</h6>
                            <p class="text-sm mb-0">
                                <i class="fa fa-arrow-up text-success"></i>
                                <span class="font-weight-bold">4% more</span> in 2021
                            </p>
                        </div>
                        <div class="card-body p-3">
                            <div class="chart">
                                <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- calender --}}
                <div class="col-lg-8">
                    <div class="card card-carousel overflow-hidden h-100 p-0">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title m-0 me-2">Calendar</h5>
                            <div class="dropdown">
                                <button id="prevMonth" class="btn btn-outline-primary btn-sm me-2">← Prev</button>
                                <button id="nextMonth" class="btn btn-outline-primary btn-sm">Next →</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="calendar" class="table-responsive">
                                <!-- Kalender akan dirender di sini oleh JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>
@endsection