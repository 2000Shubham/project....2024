<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $resetPasswordUrl;
    private $userId;
    private $token;

    /**
     * Create a new message instance.
     */
    public function __construct($resetPasswordUrl, $userId, $token)
    {
        $this->resetPasswordUrl = $resetPasswordUrl;
        $this->userId = $userId;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $emailToken = $this->token;
        $getTemplate =  User::getEmailtemplate($emailToken);

        // print_r($emailTemplate);exit;

        $emailTemplate = str_replace('{{ $resetPasswordUrl }}', $this->resetPasswordUrl, $getTemplate);

       // print_r($emailTemplate);exit;

        // Set the email content from the template
        return $this->html($emailTemplate)
            ->with('userId', $this->userId)
            ->with('token', $this->token);
    }
}
