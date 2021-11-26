@component('mail::message')
# Report Daily

Hello {{ $recipientName }}, follow the report with total sales.

Thanks and regards.,
<br>
{{ config('app.name') }}
@endcomponent
