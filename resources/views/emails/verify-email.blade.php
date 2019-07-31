@component('mail::message')
	# Introduction

	This email just got registered under {{ config('app.name') }}

	@component('mail::button', ['url' => env('APP_URL','http://localhost').':8000/'])
			Verify you made this action
	@endcomponent

	Thanks,<br>
	{{ config('app.name') }}
@endcomponent
