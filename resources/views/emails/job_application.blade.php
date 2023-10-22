@include('emails.email_head')
Hi {{ $user_data->name ?? null}},
<br>
<br>
You have received an application from {{ $job_applicant->staff->name ?? null}}.
<br>
<br>
Do you want to accept the application? <a href="{{ env('APP_URL') ?? 'https://thesmokeshowstaff.datanetbpodemo.com' }}/invitations/{{ $job_applicant->job_id }}">Click here</a> to respond.
<br>
<br>
<table border="0" cellpadding="0" cellspacing="0" style="width:100%">
<tbody>
<tr>
<td style="font-weight:bold;width:50px">Event:</td>
<td>{{ $job_applicant->job->title ?? null}}</td>
</tr>
<tr>
<td style="font-weight:bold;width:50px">Job:</td>
<td>{{ $job_applicant->job->job_title ?? null}}</td>
</tr>
<tr>
<td style="font-weight:bold;width:50px">Date:</td>
<td>{{ date('m/d/Y', strtotime($job_applicant->job->date)) ?? null}}</td>
</tr>
</tbody>
</table>
<br>
<br>
@if($job_applicant->description)
{{ $job_applicant->staff->name ?? null}} said:
<br>
<br>
<em>{{ $job_applicant->description ?? null}}</em>
<br>
<br>
@endif
Thanks.
<br>
<br>
@include('emails.email_foot')
