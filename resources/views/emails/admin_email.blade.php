@include('emails.email_head')

Hi {{ $user_data->name ?? null}},
<br>
<br>

<strong><i>{{ $content }}</i></strong>
<br>
<br>
Thanks,
<br>
<br>
@include('emails.email_foot')