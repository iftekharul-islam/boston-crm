@extends('layouts.app')
@section('content')
    <div class="dashboard bg-platinum dashboard-space">
        <!-- dashboard count -->
        <div class=" dashboard-boxes row">
            <div class="dashboard-small-box col-sm-5 col-md-4 col-lg-3 col-xxl-2">
                <div class="bg-white box-space">
                    <h1 class="big-number">{{ $data['all'] }}</h1>
                    <p class="mb-0 text-light-black text-medium"> Total issue</p>
                </div>
            </div>
            <div class="dashboard-small-box col-sm-5 col-md-4 col-lg-3 col-xxl-2">
                <div class="bg-white box-space">
                    <h1 class="big-number">{{ $data['open'] }}</h1>
                    <p class="mb-0 text-light-black text-medium"> Open task</p>
                </div>
            </div>
            <div class="dashboard-small-box col-sm-5 col-md-4 col-lg-3 col-xxl-2">
                <div class="bg-white box-space">
                    <h1 class="big-number">{{ $data['my'] }}</h1>
                    <p class="mb-0 text-light-black text-medium"> My task</p>
                </div>
            </div>
            <div class="dashboard-small-box col-sm-5 col-md-4 col-lg-3 col-xxl-2">
                <div class="bg-white box-space">
                    <h1 class="big-number">{{ $data['all'] - $data['open'] }}</h1>
                    <p class="mb-0 text-light-black text-medium"> Complete task</p>
                </div>
            </div>
        </div>
        <div class="row chart">
            <div class="chart-box col-lg-12">
                <ticket-list></ticket-list>
            </div>
        </div>

    </div>
    </body>
@endsection


