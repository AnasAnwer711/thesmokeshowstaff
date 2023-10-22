@include('emails.email_head')

    Hi {{ $user_data->name ?? null}},
    <br>
    <br>
    Thank you for joining <span class="il">The Smoke Show Staff</span>. We look forward to helping
    you find some great people for your upcoming event!
    <br>
    <br>
    To attract the best people please describe the event and jobs in as much detail as
    you can (how many people will be there, how many <span class="il">staff</span> you
    are hiring, what the event is in aid of etc).
    <br>
    <br>
    <br>
    <br>
    Enjoy the party!
    <br>
    <br>
    Thanks,
    <br>
    <br>
    @include('emails.email_foot')