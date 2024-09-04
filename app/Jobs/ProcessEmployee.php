<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\EmployeeMail;
use Mail;

class ProcessEmployee implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public $emp_name;

    public function __construct($employee)
    {
        $this->emp_name = $employee->name;

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $mailData = [
            'title' => $this->emp_name,
            'body' => 'Welcome'
        ];
        Mail::to($this->email)->send(new EmployeeMail($mailData));
    }
}
