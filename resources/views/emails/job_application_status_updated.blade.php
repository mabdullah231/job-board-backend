@component('mail::message')
    # Job Application Status Updated

    **Job Title:** {{ $jobApplication->job->title }}

    **Applicant Name:** {{ $jobApplication->user->name }}

    **Status:** {{ $jobApplication->status }}

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
