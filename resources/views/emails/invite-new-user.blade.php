<!DOCTYPE html>
<html>
<head>
    <title>{{ env('APP_NAME') }}</title>
</head>
<body>
<p>{{ __('messages.mail_template.new_user.hi') }}  {{ $name }}</p>

<div>Welcome to {{ env('APP_NAME') }}</div>
<div>Email: {{ $email }}</div>
<div>Password: {{ $password }}</div>
<a href="{{ config()->get('app.url')  }}/accept-new-user/{{ $email }}">{{ __('messages.mail_template.invite_accept') }}</a>

</body>
</html>
