@include('emails.email_head')

Hi {{ $user_data->name ?? null}},
<br>
<br>
Your payment attempt has been failed. After 3 attempt your account has been suspended. Kindly review your card details before your account suspended.
<br>
<br>
Thanks,
<br>
<br>
@include('emails.email_foot')