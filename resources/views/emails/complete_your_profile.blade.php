@include('emails.email_head')
    <p style="margin:10px 0;padding:0;color:#757575;font-family:Helvetica;font-size:16px;line-height:150%;text-align:left">
        Thank you for your interest in joining {{ $basic_setting->name ?? null }} crew.<br>
        <br>
        Since {{ $basic_setting->name ?? null }} began in 2022 we have worked&nbsp;with&nbsp;1,000's of hosts in Canada and have learned a thing or two about what it takes to offer an exceptional experience to our customers while ensuring our staff HAVE the best time and get paid to party!<br>
        <br>
        You are <strong>so close</strong> to&nbsp;completing your profile and being eligible&nbsp;to accept and apply for jobs.&nbsp; We know from experience, high-quality profiles equal high-quality consistent work.<br>
        <br>
        If you have any questions please reach out to <a href="mailto:{{ $basic_setting->email ?? null }}" style="color:#e71e6e;font-weight:normal;text-decoration:underline" target="_blank">{{ $basic_setting->email ?? null }}</a>, we are happy to help with any questions you may have.<br>
        <br>
        <br>
        We look forward to partying with you soon,<br>
    </p>
    
    @include('emails.email_foot')