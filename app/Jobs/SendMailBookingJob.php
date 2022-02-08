<?php

namespace App\Jobs;

use App\Mail\SendMailBooking;
use App\Mail\SendMailBookingCancel;
use App\Mail\SendMailBookingComplete;
use App\Mail\SendMailBookingConfirm;
use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailBookingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $booking;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->booking->status == 1) {
            $email = new SendMailBooking($this->booking);
            Mail::to('admin@ngaodu.com')->send($email);
        }

        if ($this->booking->status == 2) {
            $email = new SendMailBookingConfirm($this->booking);
            Mail::to($this->booking->customer->email)->send($email);
        }

        if ($this->booking->status == 3) {
            $email = new SendMailBookingComplete($this->booking);
            Mail::to($this->booking->customer->email)->send($email);
        }

        if ($this->booking->status == 4) {
            $email = new SendMailBookingCancel($this->booking);
            Mail::to($this->booking->customer->email)->send($email);
        }
    }
}
