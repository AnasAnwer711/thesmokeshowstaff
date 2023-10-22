@include('emails.email_head')

Hi {{ $user_data->name ?? null}},
<br>
<br>
Your '{{ $job_applicant->job->title }}' job has been {{ $current_status }} successfully by {{ $source_data->name }}. 
<br>
<br>
Thanks,
<br>
<br>
@include('emails.email_foot')