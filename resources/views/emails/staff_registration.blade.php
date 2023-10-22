@include('emails.email_head')
    Hi {{ $user_data->name ?? null}},
    <br>
    <br>
    
    Welcome to The Smoke Show Staff. A few tips below on how to use our awesome party site:
    <br>
    <br>
    The Smoke Show Staff is an automated jobs platform where everything goes through the site. Can't make a job - that's ok, but you must cancel on the site so the position is freed up and the client can hire someone else.
    <br>
    <br>
    Once you are booked for a job you will get the contact information of the organiser and can call them freely to arrange anything you may need.
    <br>
    <br>
    Party on!
    <br>
    <br>
    Thanks for joining the Party!
    <br>
    <br>
    @include('emails.email_foot')