<!DOCTYPE html>
<html>
<head>
    <title>{{ env('APP_NAME') }}</title>
</head>
<body>
<p>{{ __('messages.mail_template.new_user.hi') }}  {{ $name }}</p>

<div>Welcome to {{ env('APP_NAME') }}</div>
<a href="{{ config('app.url') }}">
    <img src="{{ asset('img/boston-signature.png') }}" style="width: 100%" alt="logo">
</a>

</body>
</html>
