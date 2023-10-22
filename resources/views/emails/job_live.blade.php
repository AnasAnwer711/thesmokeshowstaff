@include('emails.email_head')

Hi {{ $user_data->name ?? null}},
<br>
<br>
<h2>Great news - Your job is now live!</h2>
<br>
<br>
<table border="0" cellpadding="0" cellspacing="0" style="width:100%">
    <tbody>
        <tr>
            <td style="font-weight:bold;width:50px">Step 1:</td>
            <td>RECEIVE APPLICATIONS FROM TRUSTED WORKERS WITHIN MINUTES</td>
        </tr>
        <tr>
            <td style="font-weight:bold;width:105px">Step 2:</td>
            <td>BOOK THE BEST PERSON FOR JOB</td>
        </tr>
        <tr>
            <td style="font-weight:bold;width:105px">Step 3:</td>
            <td>PARTY LIKE NOBODY'S WATCHING</td>
        </tr>
    </tbody>
</table>
<br>
<br>
Thanks,
<br>
<br>
@include('emails.email_foot')