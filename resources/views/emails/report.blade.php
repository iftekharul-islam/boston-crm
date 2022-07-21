<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register confirmation email template</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        .main {
            max-width: 600px;
            width: 100%;
            background: #F6F6F6;
            margin: 0 auto;
            font-family: "Nunito-regular", sans-serif;
        }

        .main-top {
            padding: 32px 32px 22px 32px;
        }

        .headerclass {
            justify-content: space-between;
            align-items: center!important;
            justify-content: space-between;
            padding-left: 18px;
            padding-right: 18px;
            background: #ffffff;
            border-radius: 8px;
            margin-bottom: 48px;
            padding-bottom: 20px;
        }
        table {
            border-collapse: collapse;
        }
        tr {
            border-bottom: 1px solid #E5E5E5;
            border-width: 1px 0;
        }
    </style>
</head>

<body>
<div class="main">
    <!-- header -->
    <header class="header">
        <a href="{{ config('app.url') }}">
            <img src="{{ asset('img/email-bg.png') }}" style="width: 100%" alt="logo">
        </a>
    </header>
    <div class="main-top">
        <!-- Greetings -->
        <p class="name" style="font-size: 18px; line-height: 30px; color: #2C364A; padding-bottom: 20px">
            Hi {{ $name }},</p>
        <p class="name" style="font-size: 18px; line-height: 20px; color: #2C364A;">
            As a Boston Appraisal Services employee, this is your daily report. Please look into it.</p>

        <h1 class="name" style=" padding-top: 25px; padding-bottom: 18px;
                font-weight: bold; font-size: 20px; line-height: 10px; color: #2C364A;">Report on {{ \Illuminate\Support\Carbon::today()->format('d M Y') }}</h1>
            @if($dataExists)
                @if($order['to_be_scheduled']['total'])
                    <div style="justify-content: center; padding-top: 12px; align-items: center;" class="headerclass">
                        <h1 class="name" style="font-weight: bold; font-size: 16px; color: #19B7A2; padding-bottom: 10px">
                            {{ $order['to_be_scheduled']['name'] }} ({{ $order['to_be_scheduled']['total'] }})</h1>
                        <table style="width: 100%">
                            <tr>
                                <td style="width: 20%; text-align: left; padding-top: 10px; padding-bottom: 10px">Order no</td>
                                <td style="width: 40%; text-align: center; padding-top: 10px; padding-bottom: 10px">Client name</td>
                                <td style="width: 40%; text-align: center; padding-top: 10px; padding-bottom: 10px">Address</td>
                            </tr>
                            @foreach($order['to_be_scheduled']['data'] as $item)
                                <tr>
                                    <td style="width: 20%; text-align: left; padding-top: 10px; padding-bottom: 10px">{{ $item['order_no'] }}</td>
                                    <td style="width: 40%; text-align: center; padding-top: 10px; padding-bottom: 10px"><b>{{ $item['name'] }}</b></td>
                                    <td style="width: 40%; text-align: left; padding-top: 10px; padding-bottom: 10px">{{ $item['address'] }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                @endif
                @if($order['scheduled']['total'])
                    <div style="justify-content: center; padding-top: 12px; align-items: center;" class="headerclass">
                        <h1 class="name" style="font-weight: bold; font-size: 16px; color: #19B7A2; padding-bottom: 10px">
                            {{ $order['scheduled']['name'] }} ({{ $order['scheduled']['total'] }})</h1>
                        <table style="width: 100%">
                            <tr>
                                <td style="width: 20%; text-align: left; padding-top: 10px; padding-bottom: 10px">Order no</td>
                                <td style="width: 40%; text-align: center; padding-top: 10px; padding-bottom: 10px">Client name</td>
                                <td style="width: 40%; text-align: center; padding-top: 10px; padding-bottom: 10px">Address</td>
                            </tr>
                            @foreach($order['scheduled']['data'] as $item)
                                <tr>
                                    <td style="width: 20%; text-align: left; padding-top: 10px; padding-bottom: 10px">{{ $item['order_no'] }}</td>
                                    <td style="width: 40%; text-align: center; padding-top: 10px; padding-bottom: 10px"><b>{{ $item['name'] }}</b></td>
                                    <td style="width: 40%; text-align: left; padding-top: 10px; padding-bottom: 10px">{{ $item['address'] }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                @endif
                @if($order['rescheduled']['total'])
                    <div style="justify-content: center; padding-top: 12px; align-items: center;" class="headerclass">
                        <h1 class="name" style="font-weight: bold; font-size: 16px; color: #19B7A2; padding-bottom: 10px">
                            {{ $order['rescheduled']['name'] }} ({{ $order['rescheduled']['total'] }})</h1>
                        <table style="width: 100%">
                            <tr>
                                <td style="width: 20%; text-align: left; padding-top: 10px; padding-bottom: 10px">Order no</td>
                                <td style="width: 40%; text-align: center; padding-top: 10px; padding-bottom: 10px">Client name</td>
                                <td style="width: 40%; text-align: center; padding-top: 10px; padding-bottom: 10px">Address</td>
                            </tr>
                            @foreach($order['rescheduled']['data'] as $item)
                                <tr>
                                    <td style="width: 20%; text-align: left; padding-top: 10px; padding-bottom: 10px">{{ $item['order_no'] }}</td>
                                    <td style="width: 40%; text-align: center; padding-top: 10px; padding-bottom: 10px"><b>{{ $item['name'] }}</b></td>
                                    <td style="width: 40%; text-align: left; padding-top: 10px; padding-bottom: 10px">{{ $item['address'] }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                @endif
                @if($order['inspected']['total'])
                <div style="justify-content: center; padding-top: 12px; align-items: center;" class="headerclass">
                    <h1 class="name" style="font-weight: bold; font-size: 16px; color: #19B7A2; padding-bottom: 10px">
                        {{ $order['inspected']['name'] }} ({{ $order['inspected']['total'] }})</h1>
                    <table style="width: 100%">
                        <tr>
                            <td style="width: 20%; text-align: left; padding-top: 10px; padding-bottom: 10px">Order no</td>
                            <td style="width: 40%; text-align: center; padding-top: 10px; padding-bottom: 10px">Client name</td>
                            <td style="width: 40%; text-align: center; padding-top: 10px; padding-bottom: 10px">Address</td>
                        </tr>
                        @foreach($order['inspected']['data'] as $item)
                            <tr>
                                <td style="width: 20%; text-align: left; padding-top: 10px; padding-bottom: 10px">{{ $item['order_no'] }}</td>
                                <td style="width: 40%; text-align: center; padding-top: 10px; padding-bottom: 10px"><b>{{ $item['name'] }}</b></td>
                                <td style="width: 40%; text-align: left; padding-top: 10px; padding-bottom: 10px">{{ $item['address'] }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            @endif
            @else
            <div style="justify-content: center; padding-top: 12px; align-items: center;" class="headerclass">
                <h1 class="name" style="text-align: center; font-weight: bold; font-size: 18px; color: #000000; padding-bottom: 10px; padding-top: 10px">
                    No data Available for Today
                </h1>
            </div>
            @endif
        <div style="justify-content: center; padding-top: 25px; align-items: center;">
            <p style="text-align: center; color: #2F415E;">
                Netsoft Holdings, LLC - 11650 Olio Rd. Suite #1000 -
                193 Fishers, IN 46037, United States
            </p>
        </div>

        <div style="padding-top: 25px">
            <p style="text-align: center; color: #2F415E;">
                <a style="align-items: center; color: #19B7A2; text-decoration: none" href="{{ config('app.url') }}">Visit Site</a>
            </p>

        </div>

    </div>

</div>
</body>

</html>
