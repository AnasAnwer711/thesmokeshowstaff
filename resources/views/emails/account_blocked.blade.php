@include('emails.email_head')

Hi {{ $user_data->name ?? null}},
<br>
<br>
Your account has been suspended. Kindly contact with adminstration for further details 
<br>
<br>
Thanks,
<br>
<br>
@include('emails.email_foot')