@extends('layouts.app')
@section('content')
    <div class="dashboard bg-platinum dashboard-space">
        <!-- dashboard count -->
        <div class=" dashboard-boxes row">
            <div class="dashboard-small-box col-sm-5 col-md-4 col-lg-3 col-xxl-2">
                <div class="bg-white box-space">
                    <h1 class="big-number">15</h1>
                    <p class="mb-0 text-light-black text-medium"> Todays order done</p>
                </div>
            </div>
            <div class="dashboard-small-box col-sm-5 col-md-4 col-lg-3 col-xxl-2">
                <div class="bg-white box-space">
                    <h1 class="big-number">15</h1>
                    <p class="mb-0 text-light-black text-medium"> Todays order done</p>
                </div>
            </div>
            <div class="dashboard-small-box col-sm-5 col-md-4 col-lg-3 col-xxl-2">
                <div class="bg-white box-space">
                    <h1 class="big-number">15</h1>
                    <p class="mb-0 text-light-black text-medium"> Todays order done</p>
                </div>
            </div>
            <div class="dashboard-small-box col-sm-5 col-md-4 col-lg-3 col-xxl-2">
                <div class="bg-white box-space">
                    <h1 class="big-number">15</h1>
                    <p class="mb-0 text-light-black text-medium"> Todays order done</p>
                </div>
            </div>
            <div class="dashboard-small-box col-sm-5 col-md-4 col-lg-3 col-xxl-2">
                <div class="bg-white box-space">
                    <h1 class="big-number">$5615</h1>
                    <p class="mb-0 text-light-black text-medium"> Todays order done</p>
                </div>
            </div>
            <div class="dashboard-small-box col-sm-5 col-md-4 col-lg-3 col-xxl-2">
                <div class="bg-white box-space">
                    <h1 class="big-number">$45415</h1>
                    <p class="mb-0 text-light-black text-medium"> Todays order done</p>
                </div>
            </div>
        </div>
        <div class="row chart">
            <!-- chart  -->
            <div class="chart-box col-lg-6">
                <div class="bg-white chart-box-space">
                    <h1>Chart Js here</h1>
                </div>
            </div>
            <div class="chart-box col-lg-6">
                <div class="bg-white chart-box-space">
                    <h1>Chart Js here</h1>
                </div>
            </div>
            <div class="chart-box col-lg-6">
                <div class="bg-white chart-box-space">
                    <h1>Chart Js here</h1>
                </div>
            </div>
            <div class="chart-box col-lg-6">
                <div class="bg-white  chart-box-space">
                    <div class="chart-box-header-btn d-flex align-items-center mgb-32 flex-wrap">
                        <button class="chart-btn d-flex align-items-center justify-content-between mb-2 active">
                            Appraiser <span class="ms-1">(88)</span></button>
                        <button class="chart-btn d-flex align-items-center justify-content-between mb-2">Client <span
                                class="ms-1">(88)</span></button>
                        <button class="chart-btn d-flex align-items-center justify-content-between mb-2">Loan type <span
                                class="ms-1">(8)</span></button>
                        <button class="chart-btn d-flex align-items-center justify-content-between mb-2">Report type
                            <span class="ms-1">(88)</span></button>
                        <button class="chart-btn d-flex align-items-center justify-content-between mb-2">Property type
                            <span class="ms-1">(88)</span></button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">Group</th>
                                <th scope="col">Appraiser name</th>
                                <th scope="col">Orders</th>
                                <th scope="col">Total billed</th>
                                <th scope="col">Paid amount</th>
                                <th scope="col">Remaining</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Appraiser</td>
                                <td>Sadik Rahman</td>
                                <td>425</td>
                                <td>$12,365</td>
                                <td>$7,365</td>
                                <td>$5,000</td>
                                <td>
                                    <router-link to="/" class="view">View</router-link>
                                </td>
                            </tr>
                            <tr>
                                <td>Appraiser</td>
                                <td>Sadik Rahman</td>
                                <td>425</td>
                                <td>$12,365</td>
                                <td>$7,365</td>
                                <td>$5,000</td>
                                <td>
                                    <router-link to="/" class="view">View</router-link>
                                </td>
                            </tr>
                            <tr>
                                <td>Appraiser</td>
                                <td>Sadik Rahman</td>
                                <td>425</td>
                                <td>$12,365</td>
                                <td>$7,365</td>
                                <td>$5,000</td>
                                <td>
                                    <router-link to="/" class="view">View</router-link>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mgt-32">
                        <a href="#" class="view-all">View all</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </body>
@endsection


