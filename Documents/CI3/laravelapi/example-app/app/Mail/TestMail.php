<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

  private $email_template;


  /**
   * Create a new message instance.
   *
   * @return void
   */
  // public function __construct(private string $title, private string  $body)
  // {
  //     //
  // }

  // public function envelope(): Envelope
  // {
  //     return new Envelope(
  //         subject: 'Welcome to laracoding.com EmailDemo',
  //     );
  // }

  // public function content(): Content
  // {
  //     return new Content(
  //        view: 'emails.welcome',
  //         with: [
  //             'title' => $this->title,
  //             'body' => $this->body,
  //         ],
  //     );
  // }


  // public function __construct($userId)
  // {
  //     // $this->content = $content;
  //     $this->userId = $userId;
  // }

  public function __construct($email_template)
  {
    //$this->Email_address = $Email_address;
    $this->email_template = $email_template;
  //echo "testing....";exit;
    // print_r($this->Email_address);exit;

  }

  public function attachments(): array
  {
    return [
      $this->text("welcome to shubham")
    ];
  }
  /**
   * Build the message.
   *
   * @return $this
   */
  // public function build()
  // {
  //     return "mail send successfully";
  // }

  public function build()
  {

   // echo $this->email_template;exit;
   //echo "testing...";exit;
    // $emailTemplate = DB::table('agentdetails')
    //   ->where('email', $this->Email_address)
    //   ->value('email_template');

     //  print_r($this->email_template);exit;
    // return $this->view('welcome', ['content' => $this->content]);





    //  return $this->view('welcome');

    // return $this->text("shubham");

    // return $this->view("verifycomponent");

    // return $this->view('verifycomponent', [
    //     'registrationUrl' => 'http://127.0.0.1:8000/customer/register'
    // ]);

    // $registrationUrl = route('register', ['id' => $this->userId]);

    // return $this->view('verifycomponent')
    //     ->with('registrationUrl', $registrationUrl);

    // return $this->view('verifycomponent')
    //     ->with('resetPasswordUrl', $this->resetPasswordUrl) // Pass the resetPasswordUrl to the view
    //     ->with(
    //         [
    //             // 'userId' => $this->userId,
    //             'token' => $this->token
    //         ]

    //     );

    // print_r($emailTemplate);
    // exit;



    // $emailTemplate = str_replace('{{ $resetPasswordUrl }}', $this->resetPasswordUrl, $emailTemplate);

    //print_r($emailTemplate);exit;

    // Use the modified email template

    //return $this->view('welcome');
    return $this->html($this->email_template);


    // return $this->html($emailTemplate)
    //     ->with('resetPasswordUrl', $this->resetPasswordUrl)
    //     ->with('userId', $this->userId)
    //     ->with('token', $this->token);
  }
}
