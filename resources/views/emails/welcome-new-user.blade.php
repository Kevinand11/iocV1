@component('mail::message')
# Introduction

Welcome to IocMart, where we make all your shopping dreams come true

@component('mail::button', ['url' => env('APP_URL','http://localhost').':8000/profile'])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
