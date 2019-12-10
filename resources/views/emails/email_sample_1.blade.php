@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
    # @lang('Whoops!')
@else
    # @lang('Welcome to popularness!')
@endif
@endif
@if(!empty($body))
{{$body}}
@else
This is just sample mail body content!
@endif


{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@lang('Regards'),<br>
{{ config('app.name') }}
@endif
@endcomponent
