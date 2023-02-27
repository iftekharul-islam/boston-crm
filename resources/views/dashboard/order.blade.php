@extends('layouts.app')
@section('content')
    <div class="order bg-platinum dashboard-space">
        {{-- open archive --}}
        <div class="open-archive d-flex">
            <div class="open-archive-left">
                <p class="mb-2">Open</p>
                <div class="d-flex flex-wrap">
                    <div class="open-archive-box">
                        <button class="order-sml-box">
                            <h5 class="mb-2 number">13</h5>
                            <p class="mb-0 text">Due today</p>
                            <span class="open-badges badges"></span>
                        </button>
                    </div>
                    <div class="open-archive-box">
                        <button class="order-sml-box">
                            <h5 class="mb-2 number">13</h5>
                            <p class="mb-0 text">Due today</p>
                            <span class="open-badges badges"></span>
                        </button>
                    </div>
                    <div class="open-archive-box">
                        <button class="order-sml-box">
                            <h5 class="mb-2 number">13</h5>
                            <p class="mb-0 text">Due today</p>
                            <span class="open-badges badges"></span>
                        </button>
                    </div>
                    <div class="open-archive-box">
                        <button class="order-sml-box">
                            <h5 class="mb-2 number">13</h5>
                            <p class="mb-0 text">Due today</p>
                            <span class="open-badges badges"></span>
                        </button>
                    </div>
                    <div class="open-archive-box">
                        <button class="order-sml-box">
                            <h5 class="mb-2 number">13</h5>
                            <p class="mb-0 text">Due today</p>
                            <span class="open-badges badges"></span>
                        </button>
                    </div>
                    <div class="open-archive-box">
                        <button class="order-sml-box">
                            <h5 class="mb-2 number">13</h5>
                            <p class="mb-0 text">Due today</p>
                            <span class="open-badges badges"></span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="open-archive-right">
                <p class="mb-2">Archive</p>
                <div class="d-flex">
                    <div class="open-archive-box">
                        <button class="order-sml-box">
                            <h5 class="mb-2 number">13</h5>
                            <p class="mb-0 text">Due today</p>
                            <span class="archive-badges badges"></span>
                        </button>
                    </div>
                    <div class="open-archive-box">
                        <button class="order-sml-box">
                            <h5 class="mb-2 number">13</h5>
                            <p class="mb-0 text">Due today</p>
                            <span class="archive-badges badges"></span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="open-archive-btn">
                <a href="{{ route('order.add')}}" class="button button-primary ">Add new order</a>
            </div>
        </div>
        {{-- In progress --}}
        <div class="open-archive inprogress-tab d-flex">
            <div class="open-archive-left">
                <p class="mb-2">In progress</p>
                <div class="d-flex inprogress-tab-top">
                    <div class="open-archive-box">
                        <button class="order-sml-box">
                            <h5 class="mb-2 number">13</h5>
                            <p class="mb-0 text">Due today</p>
                            <span class="progress-badges badges"></span>
                        </button>
                    </div>
                    <div class="open-archive-box">
                        <button class="order-sml-box">
                            <h5 class="mb-2 number">13</h5>
                            <p class="mb-0 text">Due today</p>
                            <span class="progress-badges badges"></span>
                        </button>
                    </div>
                    <div class="open-archive-box">
                        <button class="order-sml-box">
                            <h5 class="mb-2 number">13</h5>
                            <p class="mb-0 text">Due today</p>
                            <span class="progress-badges badges"></span>
                        </button>
                    </div>
                    <div class="open-archive-box">
                        <button class="order-sml-box">
                            <h5 class="mb-2 number">13</h5>
                            <p class="mb-0 text">Due today</p>
                            <span class="progress-badges badges"></span>
                        </button>
                    </div>
                    <div class="open-archive-box">
                        <button class="order-sml-box">
                            <h5 class="mb-2 number">13</h5>
                            <p class="mb-0 text">Due today</p>
                            <span class="progress-badges badges"></span>
                        </button>
                    </div>
                    <div class="open-archive-box">
                        <button class="order-sml-box">
                            <h5 class="mb-2 number">13</h5>
                            <p class="mb-0 text">Due today</p>
                            <span class="progress-badges badges"></span>
                        </button>
                    </div>
                    <div class="open-archive-box">
                        <button class="order-sml-box">
                            <h5 class="mb-2 number">13</h5>
                            <p class="mb-0 text">Due today</p>
                            <span class="progress-badges badges"></span>
                        </button>
                    </div>
                    <div class="open-archive-box">
                        <button class="order-sml-box">
                            <h5 class="mb-2 number">13</h5>
                            <p class="mb-0 text">Due today</p>
                            <span class="progress-badges badges"></span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="open-archive-right">
                <p class="mb-2">Client revisions</p>
                <div class="d-flex">
                    <div class="open-archive-box">
                        <button class="order-sml-box">
                            <h5 class="mb-2 number">13</h5>
                            <p class="mb-0 text">Due today</p>
                            <span class="revision-badges badges"></span>
                        </button>
                    </div>
                    <div class="open-archive-box">
                        <button class="order-sml-box">
                            <h5 class="mb-2 number">13</h5>
                            <p class="mb-0 text">Due today</p>
                            <span class="revision-badges badges"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        {{-- report --}}
        <div class="report bg-white">
            <div class="report-top d-flex justify-content-between mgb-32 flex-wrap">
                <div class="left chart-box-header-btn d-flex flex-wrap justify-content-between">
                    <button class="chart-btn h-32 d-flex align-items-center justify-content-between mb-2 active">Appraiser <span class="ms-1">(9)</span></button>
                    <button class="chart-btn h-32 d-flex align-items-center justify-content-between mb-2">Appraiser <span class="ms-1">(9)</span></button>
                    <button class="chart-btn h-32 d-flex align-items-center justify-content-between mb-2">Appraiser <span class="ms-1">(9)</span></button>
                    <button class="chart-btn h-32 d-flex align-items-center justify-content-between mb-2">Appraiser <span class="ms-1">(9)</span></button>
                    <button class="chart-btn h-32 d-flex align-items-center justify-content-between mb-2">Appraiser <span class="ms-1">(9)</span></button>
                </div>
                <div class="right d-flex">
                    <input type="text" class="me-3 mb-3 px-3 bdr-1 br-4 gray-border" placeholder="Search...">
                    <button class="button-primary px-4 inline-flex-center h-32 mb-2">View daily report</button>
                </div>
            </div>
            {{-- table --}}
            <div class="order-table">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order no</th>
                            <th>Client name</th>
                            <th>Property address</th>
                            <th>Appraiser</th>
                            <th>Inspector</th>
                            <th>Inspection date</th>
                            <th>Due date</th>
                            <th>Status</th>
                            <th>Map it</th>
                            <th>
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.4" d="M17.028 0H6.972C2.604 0 0 2.604 0 6.972V17.028C0 21.396 2.604 24 6.972 24H17.028C21.396 24 24 21.396 24 17.028V6.972C24 2.604 21.396 0 17.028 0Z" fill="#2F415E"/>
                                <path d="M19.5717 8.24399C19.5717 8.73599 19.1757 9.14399 18.6717 9.14399H12.3717C11.8797 9.14399 11.4717 8.73599 11.4717 8.24399C11.4717 7.75199 11.8797 7.34399 12.3717 7.34399H18.6717C19.1757 7.34399 19.5717 7.75199 19.5717 8.24399Z" fill="#2F415E"/>
                                <path d="M9.56388 7.08L6.86387 9.78C6.68387 9.96 6.45588 10.044 6.22788 10.044C5.99988 10.044 5.75988 9.96 5.59188 9.78L4.69188 8.88C4.33187 8.532 4.33187 7.956 4.69188 7.608C5.03988 7.26 5.60388 7.26 5.96388 7.608L6.22788 7.872L8.29188 5.808C8.63987 5.46 9.20388 5.46 9.56388 5.808C9.91188 6.156 9.91188 6.732 9.56388 7.08Z" fill="#2F415E"/>
                                <path d="M19.5717 16.644C19.5717 17.136 19.1757 17.544 18.6717 17.544H12.3717C11.8797 17.544 11.4717 17.136 11.4717 16.644C11.4717 16.152 11.8797 15.744 12.3717 15.744H18.6717C19.1757 15.744 19.5717 16.152 19.5717 16.644Z" fill="#2F415E"/>
                                <path d="M9.56388 15.48L6.86387 18.18C6.68387 18.36 6.45588 18.444 6.22788 18.444C5.99988 18.444 5.75988 18.36 5.59188 18.18L4.69188 17.28C4.33187 16.932 4.33187 16.356 4.69188 16.008C5.03988 15.66 5.60388 15.66 5.96388 16.008L6.22788 16.272L8.29188 14.208C8.63987 13.86 9.20388 13.86 9.56388 14.208C9.91188 14.556 9.91188 15.132 9.56388 15.48Z" fill="#2F415E"/>
                                </svg>
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>741451531</td>
                            <td><b> Petter lake </b></td>
                            <td>1453 Dorchester Ave, Boston, Ma 02</td>
                            <td>John doe</td>
                            <td>John doe</td>
                            <td>08.12.2021</td>
                            <td>01.01.2022</td>
                            <td><span class="status success-status">Scheduled</span></td>
                            <td>
                                <span class="icon-maps"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></span>
                            </td>
                            <td>
                                <a href="{{ route('order.details')}}" class="view">View</a>
                            </td>
                        </tr>
                        <tr>
                            <td>741451531</td>
                            <td><b> Petter lake </b></td>
                            <td>1453 Dorchester Ave, Boston, Ma 02</td>
                            <td>John doe</td>
                            <td>John doe</td>
                            <td>08.12.2021</td>
                            <td>01.01.2022</td>
                            <td><span class="status danger-status">Scheduled</span></td>
                            <td>
                                <span class="icon-maps"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></span>
                            </td>
                            <td>
                                <a href="{{ route('order.details')}}" class="view">View</a>
                            </td>
                        </tr>
                        <tr>
                            <td>741451531</td>
                            <td><b> Petter lake </b></td>
                            <td>1453 Dorchester Ave, Boston, Ma 02</td>
                            <td>John doe</td>
                            <td>John doe</td>
                            <td>08.12.2021</td>
                            <td>01.01.2022</td>
                            <td><span class="status warning-status">Scheduled</span></td>
                            <td>
                                <span class="icon-maps"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></span>
                            </td>
                            <td>
                                <a href="{{ route('order.details')}}" class="view">View</a>
                            </td>
                        </tr>
                        <tr>
                            <td>741451531</td>
                            <td><b> Petter lake </b></td>
                            <td>1453 Dorchester Ave, Boston, Ma 02</td>
                            <td>John doe</td>
                            <td>John doe</td>
                            <td>08.12.2021</td>
                            <td>01.01.2022</td>
                            <td><span class="status accepted-status">Scheduled</span></td>
                            <td>
                                <span class="icon-maps"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></span>
                            </td>
                            <td>
                                <a href="{{ route('order.details')}}" class="view">View</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="pagination justify-content-center mgt-32">
                <h2 class="text-center"> Pagination here</h2>
            </div>
        </div>
    </div>
@endsection
