@include('emails.email_head')
    <p style="margin:10px 0;padding:0;color:#757575;font-family:Helvetica;font-size:16px;line-height:150%;text-align:left">
        {{ $source_data->name  ?? null }} recommends you try signup with <a href="{{ env('APP_URL') ?? 'https://thesmokeshowstaff.datanetbpodemo.com' }}/signup?referral_code=SS-{{ $source_data->name }}-{{ $source_data->id }}" target="_blank">
        Referal Link
        </a>
    </p>
    <br>
    <br>
    <p style="margin:10px 0;padding:0;color:#757575;font-family:Helvetica;font-size:16px;line-height:150%;text-align:left">
        <a href="{{ env('APP_URL') ?? 'https://thesmokeshowstaff.datanetbpodemo.com' }}" target="_blank">
            The Smoke Show Staff
            </a> - hire help your first time free (for a limited time).
    </p>
    @include('emails.email_foot')