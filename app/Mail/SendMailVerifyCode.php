<?php

namespace App\Mail;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailVerifyCode extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $title = "Verify Email - NgaoDu";
        if ($this->user->type_otp == 2) {
            $title = "Reset Password Notification - NgaoDu";
        }

        return $this->subject($title)
            ->view('mails.verify_code')
            ->with('user', $this->user);
    }
}
