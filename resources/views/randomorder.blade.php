@extends('layouts.app')
@section('content')
    <div class="dashboard bg-platinum dashboard-space">
        <!-- dashboard count -->
        <div class=" dashboard-boxes row justify-content-center">
            <div class="dashboard-small-box col-md-4 text-center">
                <div class="bg-white box-space">
                    <h1 class="big-number">
                        <img src="/icons/tick.png" class="text-center" style="height: 120px">
                    </h1>
                    <br>
                    <p class=" text-light-black text-medium"> {{ $message }} </p>
                </div>
                <br><br>
                <a href="{{ url('dashboard') }}">
                    <button class="btn btn-info btn-lg">Back</button>
                </a>
                <a href="{{ url('create/random/order') }}">
                    <button class="btn btn-primary btn-lg">Create New Order</button>
                </a>
            </div>
        </div>

    </div>
    </body>
@endsection


