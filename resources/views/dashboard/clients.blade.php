@extends('layouts.app')
@section('content')
    <div class="clients bg-platinum dashboard-space">
        <div class="clients-box clients-box-main bg-white">
            {{-- clients top bar --}}
            <div class="clients-top d-flex flex-wrap justify-content-between">
                <div class="left d-flex">
                    <button class="clients-top-btn px-3 h-32 active">All <span class="ms-3">(45)</span></button>
                    <button class="clients-top-btn px-3 h-32">AMC <span class="ms-3">(45)</span></button>
                    <button class="clients-top-btn px-3 h-32">Lender <span class="ms-3">(45)</span></button>
                </div>
                <div class="right d-flex">
                    <input type="text" placeholder="Search ..." class="px-3 bdr-1 br-4 gray-border me-3">
                    <a href="{{ route('client.add')}}" class="button button-primary">Add clients</a>
                </div>
            </div>
            {{-- table --}}
            <div class="clients-table mt-3">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Client type</th>
                            <th>Client city</th>
                            <th>Adress</th>
                            <th></th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><b>Petter lake </b></td>
                            <td>e.rakib@gmail.com</td>
                            <td>+880 1710 451430</td>
                            <td>AMC</td>
                            <td>Chittagong, Bangladesh</td>
                            <td>Mirpur DOHS, Dhaka 1216</td>
                            <td>
                                <a class="eye-btn text-light-black" href="{{ route('client.view')}}">
                                    <span class="icon-eye"><span class="path1"></span><span class="path2"></span></span>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Petter lake </b></td>
                            <td>e.rakib@gmail.com</td>
                            <td>+880 1710 451430</td>
                            <td>AMC</td>
                            <td>Chittagong, Bangladesh</td>
                            <td>Mirpur DOHS, Dhaka 1216</td>
                            <td>
                                <a href="{{ route('client.view')}}" class="eye-btn text-light-black">
                                    <span class="icon-eye"><span class="path1"></span><span class="path2"></span></span>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Petter lake </b></td>
                            <td>e.rakib@gmail.com</td>
                            <td>+880 1710 451430</td>
                            <td>AMC</td>
                            <td>Chittagong, Bangladesh</td>
                            <td>Mirpur DOHS, Dhaka 1216</td>
                            <td>
                                <a href="{{ route('client.view')}}" class="eye-btn text-light-black">
                                    <span class="icon-eye"><span class="path1"></span><span class="path2"></span></span>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Petter lake </b></td>
                            <td>e.rakib@gmail.com</td>
                            <td>+880 1710 451430</td>
                            <td>AMC</td>
                            <td>Chittagong, Bangladesh</td>
                            <td>Mirpur DOHS, Dhaka 1216</td>
                            <td>
                                <a href="{{ route('client.view')}}" class="eye-btn text-light-black">
                                    <span class="icon-eye"><span class="path1"></span><span class="path2"></span></span>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            {{-- pagi nation  --}}
            <div class="pagination justify-content-center mgt-32" >
                <h2 class="text-center"> Pagination here</h2>
            </div>
        </div>
    </div>
@endsection
