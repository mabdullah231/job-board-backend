@component('mail::message')
# New Job Application Submitted

**Job Title:** {{ $jobApplication->job->title }}

**Applicant Name:** {{ $jobApplication->user->name }}

**Cover Letter:**
{{ $jobApplication->cover_letter }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent