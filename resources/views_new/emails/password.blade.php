<!-- resources/views/emails/password.blade.php -->
{{$user->user_name}}
点击链接跳转重置密码: {{ url('password/reset/'.$token) }}