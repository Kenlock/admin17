@component('mail::message')
# Hallo {{ $user->name }},

Klik <a href="{{ $user->url_new_password }}">Di sini</a> untuk memasukan password baru anda

Thanks,<br>
{{ config('app.name') }}
@endcomponent
