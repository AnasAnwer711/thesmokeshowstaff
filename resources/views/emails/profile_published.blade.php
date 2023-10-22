@include('emails.email_head')

    Hi {{ $user_data->name ?? null}},
    <br>
    <br>
    Ready to Get Paid to Party?
    <br>
    <br>
    Congratulations on being approved to our platform of charismatic party staff.
    <br>
    <br>
    {{ $basic_setting->name ?? null }} is a fantastic way to make lots of money whilst traveling, or just extra income and fun whilst meeting new people and experiencing all that life has to offer! Get your friends on board so you can party together!
    <br>
    <br>
    Please read the terms to understand how it all works, and get in touch (on the contact us page) if you have any questions.
    <br>
    <br>
    You are now free to start applying for jobs!
    <br>
    <br>
    @include('emails.email_foot')