<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report mail</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');
        body {
            font-family: 'Roboto', sans-serif;
        }
        table tr td {
            padding: 12px 12px 12px 0;
            color: #2F415E;
        }
        table tr td:nth-child(3) {
            max-width: 185px;
        }
        table thead tr td {
            border-bottom: 1px solid #E5E5E5;
        }
        table tbody tr td {
            border-bottom: 1px solid #E5E5E5;
        }
        table tbody tr td:last-of-type {
            padding-right: 0;
        }
        table tbody tr:last-of-type td {
            border-bottom: none;
        }
        .report .box {
            margin-bottom: 16px;
        }
    </style>
</head>
<body>
<!--  -->
<div class="" style="margin: 0 auto; max-width: 600px; width: 600px">
    <header class="header">
        <a href="{{ config('app.url') }}">
            <img src="{{ asset('img/email-bg.png') }}" style="width: 100%" alt="logo">
        </a>
    </header>
    <!-- main body -->
    <div class="main-body" style="background: #F6F6F6; padding: 28px 20px">
        <!-- name -->
        <div class="name">
            <p style="font-style: normal; font-weight: 400; font-size: 16px; margin-bottom: 32px;">Hi {{ $name }},</p>
            <p style="font-style: normal; font-weight: 400; font-size: 16px; line-height: 20px;">As a Boston Appraisal Services employee, this is your daily report. Please look into it.</p>
        </div>
        <!-- report -->
        <div class="report">
            <h4 style="font-style: normal;
                    font-weight: 700;
                    font-size: 20px;
                    line-height: 20px;color: #2F415E; margin-bottom: 16px">Report on {{ $date }}</h4>
            <!-- box -->

            @if($dataExists)
                @if($order['to_be_scheduled']['total'])
                    <div class="box" style="background: #FFFFFF; border-radius: 8px; padding: 16px">
                        <p style="color: #19B7A2; font-weight: 700;
                                font-size: 16px;">
                            {{ $order['to_be_scheduled']['name'] }}<span>({{ $order['to_be_scheduled']['total'] }}) </span>
                        </p>
                        <!-- table -->
                        <table style="font-size:14px; width: 100%; color: #2F415E;">
                            <thead>
                            <tr>
                                <td>Order no</td>
                                <td>Client name</td>
                                <td>Address</td>
        {{--                        <td></td>--}}
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order['to_be_scheduled']['data'] as $item)
                                 <tr>
                                    <td>{{ $item['order_no'] }}</td>
                                    <td style="font-weight: bold;">{{ $item['name'] }}</td>
                                    <td>{{ $item['address'] }}</td>
        {{--                            <td>--}}
        {{--                                <a href="" style="text-decoration:none ;display:inline-block;">--}}
        {{--                                    <svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
        {{--                                        <path opacity="0.5" d="M16.7083 5.625C14.7833 2.6 11.9666 0.858337 8.99996 0.858337C7.51663 0.858337 6.07496 1.29167 4.75829 2.1C3.44163 2.91667 2.25829 4.10834 1.29163 5.625C0.458293 6.93334 0.458293 9.05834 1.29163 10.3667C3.21663 13.4 6.03329 15.1333 8.99996 15.1333C10.4833 15.1333 11.925 14.7 13.2416 13.8917C14.5583 13.075 15.7416 11.8833 16.7083 10.3667C17.5416 9.06667 17.5416 6.93334 16.7083 5.625ZM8.99996 11.3667C7.13329 11.3667 5.63329 9.85834 5.63329 8C5.63329 6.14167 7.13329 4.63334 8.99996 4.63334C10.8666 4.63334 12.3666 6.14167 12.3666 8C12.3666 9.85834 10.8666 11.3667 8.99996 11.3667Z" fill="#2F415E"/>--}}
        {{--                                        <path d="M9 5.61667C7.69167 5.61667 6.625 6.68334 6.625 8C6.625 9.30834 7.69167 10.375 9 10.375C10.3083 10.375 11.3833 9.30834 11.3833 8C11.3833 6.69167 10.3083 5.61667 9 5.61667Z" fill="#2F415E"/>--}}
        {{--                                    </svg>--}}
        {{--                                </a>--}}
        {{--                            </td>--}}
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @if($order['scheduled']['total'])
                    <div class="box" style="background: #FFFFFF; border-radius: 8px; padding: 16px">
                        <p style="color: #19B7A2; font-weight: 700;
                                font-size: 16px;">
                            {{ $order['scheduled']['name'] }}<span>({{ $order['scheduled']['total'] }}) </span>
                        </p>
                        <!-- table -->
                        <table style="font-size:14px; width: 100%; color: #2F415E;">
                            <thead>
                            <tr>
                                <td>Order no</td>
                                <td>Client name</td>
                                <td>Address</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order['scheduled']['data'] as $item)
                                 <tr>
                                    <td>{{ $item['order_no'] }}</td>
                                    <td style="font-weight: bold;">{{ $item['name'] }}</td>
                                    <td>{{ $item['address'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @if($order['rescheduled']['total'])
                    <div class="box" style="background: #FFFFFF; border-radius: 8px; padding: 16px">
                        <p style="color: #19B7A2; font-weight: 700;
                                font-size: 16px;">
                            {{ $order['rescheduled']['name'] }}<span>({{ $order['rescheduled']['total'] }}) </span>
                        </p>
                        <!-- table -->
                        <table style="font-size:14px; width: 100%; color: #2F415E;">
                            <thead>
                            <tr>
                                <td>Order no</td>
                                <td>Client name</td>
                                <td>Address</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order['rescheduled']['data'] as $item)
                                 <tr>
                                    <td>{{ $item['order_no'] }}</td>
                                    <td style="font-weight: bold;">{{ $item['name'] }}</td>
                                    <td>{{ $item['address'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @if($order['inspected']['total'])
                    <div class="box" style="background: #FFFFFF; border-radius: 8px; padding: 16px">
                        <p style="color: #19B7A2; font-weight: 700;
                                font-size: 16px;">
                            {{ $order['inspected']['name'] }}<span>({{ $order['inspected']['total'] }}) </span>
                        </p>
                        <!-- table -->
                        <table style="font-size:14px; width: 100%; color: #2F415E;">
                            <thead>
                            <tr>
                                <td>Order no</td>
                                <td>Client name</td>
                                <td>Address</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order['inspected']['data'] as $item)
                                 <tr>
                                    <td>{{ $item['order_no'] }}</td>
                                    <td style="font-weight: bold;">{{ $item['name'] }}</td>
                                    <td>{{ $item['address'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @if($order['preparation']['total'])
                    <div class="box" style="background: #FFFFFF; border-radius: 8px; padding: 16px">
                        <p style="color: #19B7A2; font-weight: 700;
                                font-size: 16px;">
                            {{ $order['preparation']['name'] }}<span>({{ $order['preparation']['total'] }}) </span>
                        </p>
                        <!-- table -->
                        <table style="font-size:14px; width: 100%; color: #2F415E;">
                            <thead>
                            <tr>
                                <td>Order no</td>
                                <td>Client name</td>
                                <td>Address</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order['preparation']['data'] as $item)
                                 <tr>
                                    <td>{{ $item['order_no'] }}</td>
                                    <td style="font-weight: bold;">{{ $item['name'] }}</td>
                                    <td>{{ $item['address'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @if($order['review']['total'])
                    <div class="box" style="background: #FFFFFF; border-radius: 8px; padding: 16px">
                        <p style="color: #19B7A2; font-weight: 700;
                                font-size: 16px;">
                            {{ $order['review']['name'] }}<span>({{ $order['review']['total'] }}) </span>
                        </p>
                        <!-- table -->
                        <table style="font-size:14px; width: 100%; color: #2F415E;">
                            <thead>
                            <tr>
                                <td>Order no</td>
                                <td>Client name</td>
                                <td>Address</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order['review']['data'] as $item)
                                 <tr>
                                    <td>{{ $item['order_no'] }}</td>
                                    <td style="font-weight: bold;">{{ $item['name'] }}</td>
                                    <td>{{ $item['address'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @if($order['upload']['total'])
                    <div class="box" style="background: #FFFFFF; border-radius: 8px; padding: 16px">
                        <p style="color: #19B7A2; font-weight: 700;
                                font-size: 16px;">
                            {{ $order['upload']['name'] }}<span>({{ $order['upload']['total'] }}) </span>
                        </p>
                        <!-- table -->
                        <table style="font-size:14px; width: 100%; color: #2F415E;">
                            <thead>
                            <tr>
                                <td>Order no</td>
                                <td>Client name</td>
                                <td>Address</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order['upload']['data'] as $item)
                                 <tr>
                                    <td>{{ $item['order_no'] }}</td>
                                    <td style="font-weight: bold;">{{ $item['name'] }}</td>
                                    <td>{{ $item['address'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @if($order['rewrite']['total'])
                    <div class="box" style="background: #FFFFFF; border-radius: 8px; padding: 16px">
                        <p style="color: #19B7A2; font-weight: 700;
                                font-size: 16px;">
                            {{ $order['rewrite']['name'] }}<span>({{ $order['rewrite']['total'] }}) </span>
                        </p>
                        <!-- table -->
                        <table style="font-size:14px; width: 100%; color: #2F415E;">
                            <thead>
                            <tr>
                                <td>Order no</td>
                                <td>Client name</td>
                                <td>Address</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order['rewrite']['data'] as $item)
                                 <tr>
                                    <td>{{ $item['order_no'] }}</td>
                                    <td style="font-weight: bold;">{{ $item['name'] }}</td>
                                    <td>{{ $item['address'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @if($order['under_rewrite']['total'])
                    <div class="box" style="background: #FFFFFF; border-radius: 8px; padding: 16px">
                        <p style="color: #19B7A2; font-weight: 700;
                                font-size: 16px;">
                            {{ $order['under_rewrite']['name'] }}<span>({{ $order['under_rewrite']['total'] }}) </span>
                        </p>
                        <!-- table -->
                        <table style="font-size:14px; width: 100%; color: #2F415E;">
                            <thead>
                            <tr>
                                <td>Order no</td>
                                <td>Client name</td>
                                <td>Address</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order['under_rewrite']['data'] as $item)
                                 <tr>
                                    <td>{{ $item['order_no'] }}</td>
                                    <td style="font-weight: bold;">{{ $item['name'] }}</td>
                                    <td>{{ $item['address'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @if($order['analysis']['total'])
                    <div class="box" style="background: #FFFFFF; border-radius: 8px; padding: 16px">
                        <p style="color: #19B7A2; font-weight: 700;
                                font-size: 16px;">
                            {{ $order['analysis']['name'] }}<span>({{ $order['analysis']['total'] }}) </span>
                        </p>
                        <!-- table -->
                        <table style="font-size:14px; width: 100%; color: #2F415E;">
                            <thead>
                            <tr>
                                <td>Order no</td>
                                <td>Client name</td>
                                <td>Address</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order['analysis']['data'] as $item)
                                 <tr>
                                    <td>{{ $item['order_no'] }}</td>
                                    <td style="font-weight: bold;">{{ $item['name'] }}</td>
                                    <td>{{ $item['address'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @if($order['quality']['total'])
                    <div class="box" style="background: #FFFFFF; border-radius: 8px; padding: 16px">
                        <p style="color: #19B7A2; font-weight: 700;
                                font-size: 16px;">
                            {{ $order['quality']['name'] }}<span>({{ $order['quality']['total'] }}) </span>
                        </p>
                        <!-- table -->
                        <table style="font-size:14px; width: 100%; color: #2F415E;">
                            <thead>
                            <tr>
                                <td>Order no</td>
                                <td>Client name</td>
                                <td>Address</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order['quality']['data'] as $item)
                                 <tr>
                                    <td>{{ $item['order_no'] }}</td>
                                    <td style="font-weight: bold;">{{ $item['name'] }}</td>
                                    <td>{{ $item['address'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @if($order['submission']['total'])
                    <div class="box" style="background: #FFFFFF; border-radius: 8px; padding: 16px">
                        <p style="color: #19B7A2; font-weight: 700;
                                font-size: 16px;">
                            {{ $order['submission']['name'] }}<span>({{ $order['submission']['total'] }}) </span>
                        </p>
                        <!-- table -->
                        <table style="font-size:14px; width: 100%; color: #2F415E;">
                            <thead>
                            <tr>
                                <td>Order no</td>
                                <td>Client name</td>
                                <td>Address</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order['submission']['data'] as $item)
                                 <tr>
                                    <td>{{ $item['order_no'] }}</td>
                                    <td style="font-weight: bold;">{{ $item['name'] }}</td>
                                    <td>{{ $item['address'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @if($order['correction']['total'])
                    <div class="box" style="background: #FFFFFF; border-radius: 8px; padding: 16px">
                        <p style="color: #19B7A2; font-weight: 700;
                                font-size: 16px;">
                            {{ $order['correction']['name'] }}<span>({{ $order['correction']['total'] }}) </span>
                        </p>
                        <!-- table -->
                        <table style="font-size:14px; width: 100%; color: #2F415E;">
                            <thead>
                            <tr>
                                <td>Order no</td>
                                <td>Client name</td>
                                <td>Address</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order['correction']['data'] as $item)
                                 <tr>
                                    <td>{{ $item['order_no'] }}</td>
                                    <td style="font-weight: bold;">{{ $item['name'] }}</td>
                                    <td>{{ $item['address'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @if($order['delivery']['total'])
                    <div class="box" style="background: #FFFFFF; border-radius: 8px; padding: 16px">
                        <p style="color: #19B7A2; font-weight: 700;
                                font-size: 16px;">
                            {{ $order['delivery']['name'] }}<span>({{ $order['delivery']['total'] }}) </span>
                        </p>
                        <!-- table -->
                        <table style="font-size:14px; width: 100%; color: #2F415E;">
                            <thead>
                            <tr>
                                <td>Order no</td>
                                <td>Client name</td>
                                <td>Address</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order['delivery']['data'] as $item)
                                 <tr>
                                    <td>{{ $item['order_no'] }}</td>
                                    <td style="font-weight: bold;">{{ $item['name'] }}</td>
                                    <td>{{ $item['address'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @if($order['cancel']['total'])
                    <div class="box" style="background: #FFFFFF; border-radius: 8px; padding: 16px">
                        <p style="color: #19B7A2; font-weight: 700;
                                font-size: 16px;">
                            {{ $order['cancel']['name'] }}<span>({{ $order['cancel']['total'] }}) </span>
                        </p>
                        <!-- table -->
                        <table style="font-size:14px; width: 100%; color: #2F415E;">
                            <thead>
                            <tr>
                                <td>Order no</td>
                                <td>Client name</td>
                                <td>Address</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order['cancel']['data'] as $item)
                                 <tr>
                                    <td>{{ $item['order_no'] }}</td>
                                    <td style="font-weight: bold;">{{ $item['name'] }}</td>
                                    <td>{{ $item['address'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @if($order['delete']['total'])
                    <div class="box" style="background: #FFFFFF; border-radius: 8px; padding: 16px">
                        <p style="color: #19B7A2; font-weight: 700;
                                font-size: 16px;">
                            {{ $order['delete']['name'] }}<span>({{ $order['delete']['total'] }}) </span>
                        </p>
                        <!-- table -->
                        <table style="font-size:14px; width: 100%; color: #2F415E;">
                            <thead>
                            <tr>
                                <td>Order no</td>
                                <td>Client name</td>
                                <td>Address</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order['delete']['data'] as $item)
                                 <tr>
                                    <td>{{ $item['order_no'] }}</td>
                                    <td style="font-weight: bold;">{{ $item['name'] }}</td>
                                    <td>{{ $item['address'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @if($order['declined']['total'])
                    <div class="box" style="background: #FFFFFF; border-radius: 8px; padding: 16px">
                        <p style="color: #19B7A2; font-weight: 700;
                                font-size: 16px;">
                            {{ $order['declined']['name'] }}<span>({{ $order['declined']['total'] }}) </span>
                        </p>
                        <!-- table -->
                        <table style="font-size:14px; width: 100%; color: #2F415E;">
                            <thead>
                            <tr>
                                <td>Order no</td>
                                <td>Client name</td>
                                <td>Address</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order['declined']['data'] as $item)
                                 <tr>
                                    <td>{{ $item['order_no'] }}</td>
                                    <td style="font-weight: bold;">{{ $item['name'] }}</td>
                                    <td>{{ $item['address'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @if($order['cancel_with_payment']['total'])
                    <div class="box" style="background: #FFFFFF; border-radius: 8px; padding: 16px">
                        <p style="color: #19B7A2; font-weight: 700;
                                font-size: 16px;">
                            {{ $order['cancel_with_payment']['name'] }}<span>({{ $order['cancel_with_payment']['total'] }}) </span>
                        </p>
                        <!-- table -->
                        <table style="font-size:14px; width: 100%; color: #2F415E;">
                            <thead>
                            <tr>
                                <td>Order no</td>
                                <td>Client name</td>
                                <td>Address</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order['cancel_with_payment']['data'] as $item)
                                 <tr>
                                    <td>{{ $item['order_no'] }}</td>
                                    <td style="font-weight: bold;">{{ $item['name'] }}</td>
                                    <td>{{ $item['address'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @if($order['cancel_without_payment']['total'])
                    <div class="box" style="background: #FFFFFF; border-radius: 8px; padding: 16px">
                        <p style="color: #19B7A2; font-weight: 700;
                                font-size: 16px;">
                            {{ $order['cancel_without_payment']['name'] }}<span>({{ $order['cancel_without_payment']['total'] }}) </span>
                        </p>
                        <!-- table -->
                        <table style="font-size:14px; width: 100%; color: #2F415E;">
                            <thead>
                            <tr>
                                <td>Order no</td>
                                <td>Client name</td>
                                <td>Address</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order['cancel_without_payment']['data'] as $item)
                                 <tr>
                                    <td>{{ $item['order_no'] }}</td>
                                    <td style="font-weight: bold;">{{ $item['name'] }}</td>
                                    <td>{{ $item['address'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @if($order['on_hold']['total'])
                    <div class="box" style="background: #FFFFFF; border-radius: 8px; padding: 16px">
                        <p style="color: #19B7A2; font-weight: 700;
                                font-size: 16px;">
                            {{ $order['on_hold']['name'] }}<span>({{ $order['on_hold']['total'] }}) </span>
                        </p>
                        <!-- table -->
                        <table style="font-size:14px; width: 100%; color: #2F415E;">
                            <thead>
                            <tr>
                                <td>Order no</td>
                                <td>Client name</td>
                                <td>Address</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order['on_hold']['data'] as $item)
                                 <tr>
                                    <td>{{ $item['order_no'] }}</td>
                                    <td style="font-weight: bold;">{{ $item['name'] }}</td>
                                    <td>{{ $item['address'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @if($order['re_active']['total'])
                    <div class="box" style="background: #FFFFFF; border-radius: 8px; padding: 16px">
                        <p style="color: #19B7A2; font-weight: 700;
                                font-size: 16px;">
                            {{ $order['re_active']['name'] }}<span>({{ $order['re_active']['total'] }}) </span>
                        </p>
                        <!-- table -->
                        <table style="font-size:14px; width: 100%; color: #2F415E;">
                            <thead>
                            <tr>
                                <td>Order no</td>
                                <td>Client name</td>
                                <td>Address</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order['re_active']['data'] as $item)
                                 <tr>
                                    <td>{{ $item['order_no'] }}</td>
                                    <td style="font-weight: bold;">{{ $item['name'] }}</td>
                                    <td>{{ $item['address'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            @else
                <div class="box" style="background: #FFFFFF; border-radius: 8px; padding: 16px">
                    <!-- empty massage -->
                    <p style="color: #2F415E; text-align: center;margin-top: 10px; margin-bottom: 10px;"> No data Available for Today</p>
                </div>
            @endif
            <div style="text-align: center;">
                <p style="padding:0 90px; margin-top:40px; margin-bottom:0;">Netsoft Holdings, LLC - 11650 Olio Rd. Suite #1000 -
                    193 Fishers, IN 46037, United States</p>
                <a href="#" style="display: inline-block;font-weight:600; color: #19B7A2; margin-top: 32px;text-decoration: none;">Visit site</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
