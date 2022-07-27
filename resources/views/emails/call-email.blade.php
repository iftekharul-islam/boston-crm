<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BAS CRM Email</title>
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
            {{ $description }},</p>

        <div style="padding-top: 25px">
            <p style="text-align: center; color: #2F415E;">
                <a style="align-items: center; color: #19B7A2; text-decoration: none" href="{{ config('app.url') }}">Visit Site</a>
            </p>

        </div>

    </div>

</div>
</body>

</html>

