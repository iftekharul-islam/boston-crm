<!DOCTYPE html>
<html>
<head>
    <title>{{ env('APP_NAME') }}</title>
</head>
<body>
<p>{{ __('messages.mail_template.new_user.hi') }}</p>

<div>Welcome to {{ env('APP_NAME') }}</div>
<div>Email: {{ $email }}</div>
<a href="{{ config()->get('app.url')  }}/accept-new-user/{{ $code }}">{{ __('messages.mail_template.invite_accept') }}</a>

</body>
</html>
