@include('emails.email_head')

Hi {{ $user_data->name ?? null}},
<br>
<br>
Great news - You job has been started!
<br>
Make sure you reached before your applicants arrived
<br>
<br>
<table border="0" cellpadding="0" cellspacing="0" style="width:100%">
    <tbody>
        <tr>
            <td style="font-weight:bold;width:50px">Event:</td>
            <td>{{ $job_applicant->job->title ?? null}}</td>
        </tr>
        <tr>
            <td style="font-weight:bold;width:105px">Job Title:</td>
            <td>{{ $job_applicant->job->job_title ?? null}}</td>
        </tr>
        <tr>
            <td style="font-weight:bold;width:105px">Job Pay:</td>
            <td>${{ $job_applicant->job_pay ?? null}}</td>
        </tr>
        <tr>
            <td style="font-weight:bold;width:105px">Suburb:</td>
            <td>{{ $job_applicant->job->address->suburb ?? null}}</td>
        </tr>
        <tr>
            <td style="font-weight:bold;width:105px">Date:</td>
            <td>{{ date('m/d/Y', strtotime($job_applicant->job->date)) ?? null}}</td>
        </tr>
        <tr>
            <td style="font-weight:bold;width:105px">Time:</td>
            <td>{{ date('h:i:s A', strtotime($job_applicant->job->start_time)) ?? null}} - {{ date('h:i:s A', strtotime($job_applicant->job->end_time)) ?? null}}</td>
        </tr>
    </tbody>
</table>
<br>
<br>
In case of any mishappen you can report dispute
<br>
If all goes fine you can mark your booking complete
<br>
<br>
Thanks,
<br>
<br>
@include('emails.email_foot')