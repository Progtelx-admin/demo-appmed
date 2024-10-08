<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;

    public $info;

    public $emails;

    public function __construct(User $user)
    {
        $this->user = $user;

        //info
        $this->info = setting('info');

        //patient code email
        $emails = setting('emails');
        $this->emails = $emails;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.reset_password', [
            'user' => $this->user,
            'emails' => $this->emails,
            'info' => $this->info,
        ])
            ->subject($this->emails['reset_password']['subject'])->from($this->info['email'], 'noreply');
    }
}
