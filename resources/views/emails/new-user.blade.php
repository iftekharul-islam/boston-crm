<!DOCTYPE html>
<html>
<head>
    <title>{{ env('APP_NAME') }}</title>
</head>
<body>
<p>{{ __('messages.mail_template.new_user.hi') }}  {{ $name }}</p>

<div>Welcome to {{ env('APP_NAME') }}</div>

</body>
</html>
