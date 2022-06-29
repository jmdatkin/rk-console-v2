@component('mail::message')
# Hello, {{ $driver->person->firstName }}!

Here are your recipients for today.

@foreach($report_data as $route)
# {{$route->name }}
@component('mail::table')
| id | First | Last | Address | Num. Meals | Home Phone | Cell Phone | Notes |
|:--:|-------|------|---------|------------|------------|------------|-------|
@foreach($route->recipients as $recipient)
| {{ $recipient->id }} | {{ $recipient->person->firstName }} | {{ $recipient->person->lastName }}| {{ preg_replace("/\r|\n/", ", ", $recipient->address) }} | {{ $recipient->numMeals }} | {{ $recipient->person->phoneHome }} | {{ $recipient->person->phoneCell }} | {{ $recipient->person->notes }} |
@endforeach
@endcomponent

@endforeach

@component('mail::button', ['url' => ''])
View in App
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent