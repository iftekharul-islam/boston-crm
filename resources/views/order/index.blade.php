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
                <a href="{{ route('orders.create')}}" class="button button-primary h-40 d-inline-flex align-items-center py-2">Add new order</a>
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
            <order-list :data="{{ json_encode($orderData) }}"></order-list>
        </div>
    </div>
@endsection
