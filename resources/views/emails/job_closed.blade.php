@include('emails.email_head')

Hi {{ $user_data->name ?? null}},
<br>
<br>
Your '{{ $job_applicant->job->title }}' job has been completed successfully and we would like to see you again. 
<br>
<br>
Thanks,
<br>
<br>
@include('emails.email_foot')