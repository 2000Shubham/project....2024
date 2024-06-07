<?php

// namespace App\Mail;

// use Illuminate\Bus\Queueable;
// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Mail\Mailable;
// use Illuminate\Mail\Mailables\Content;
// use Illuminate\Mail\Mailables\Envelope;
// use Illuminate\Queue\SerializesModels;

// class WelcomeMail extends Mailable
// {
//     use Queueable, SerializesModels;

//      private  $email_template;

//     /**
//      * Create a new message instance.
//      */
//     // public function __construct(private string $title,private string $body)
//     // {
//     //     //
      
//     // }


//     public function __construct($email_template)
//     {
//         //
//         $this->email_template = $email_template;
//     }

//     /**
//      * Get the message envelope.
//      */
//     // public function envelope(): Envelope
//     // {
//     //     return new Envelope(
//     //         subject: 'Welcome Mail',
//     //     );
//     // }

//     /**
//      * Get the message content definition.
//      */
//     // public function content(): Content
//     // {
//     //     // return new Content(
//     //     //     view: 'emails.welcome',
//     //     //     with:[
//     //     //         'title' => $this->title,
//     //     //         'body' => $this->body
//     //     //     ],
//     //     // );
//     // }

//     /**
//      * Get the attachments for the message.
//      *
//      * @return array<int, \Illuminate\Mail\Mailables\Attachment>
//      */
//     public function attachments(): array
//     {
//         return [
//             $this->text("welcome to shubham")
//         ];
//     }

//     public function build()
//     {

//         // print_r($this->email_template);exit;
//         return $this->html($this->email_template);

//     }
// }


namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AgentEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $email_template;

    /**
     * Create a new message instance.
     */
    public function __construct($email_template)
    {
        $this->email_template = $email_template;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Set the email content from the template
        return $this->html($this->email_template);
    }
}
