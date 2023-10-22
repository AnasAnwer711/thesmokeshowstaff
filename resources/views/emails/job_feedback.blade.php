@include('emails.email_head')

Hi {{ $user_data->name ?? null}},
<br>
<br>
You have not yet given feedback to {{ $target_data->name ?? null}} about event '{{ $job_applicant->job->title }}'. 
<br>
<br>
Remember to give feedback on how {{ $target_data->name ?? null}} performed in the event. 
<br>
<br>
Giving feedback is always a good idea. 
<br>
<br>
If everything went well, you should let others know that {{ $target_data->name ?? null}} can be trusted. 
<br>
<br>
If there were any problems, it's good to mention those as well. 

<br>
<br>
Thanks,
<br>
<br>
@include('emails.email_foot')