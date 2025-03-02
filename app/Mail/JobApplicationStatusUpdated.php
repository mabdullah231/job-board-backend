<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\JobApplication;

class JobApplicationStatusUpdated extends Mailable
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
        return $this->subject('Job Application Status Updated')
                    ->markdown('emails.job_application_status_updated'); // Using markdown for better email rendering
    }
}