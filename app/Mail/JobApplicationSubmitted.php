<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\JobApplication;

class JobApplicationSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public JobApplication $jobApplication)
    {
        // The `public` keyword in the constructor allows you to directly access the property in the view
    }

    /**
     * Build the message.
     */
    public function build(): self
    {
        return $this->subject('New Job Application Submitted')
                    ->markdown('emails.job_application_submitted'); // Using markdown for better email rendering
    }
}