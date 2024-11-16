<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerification extends Mailable
{
    //use Queueable, SerializesModels;

    //public $user;

    //public function __construct($user)
    //{
        //$this->user = $user;
    //}

    //public function build()
    //{
        //return $this->view('emails.verification') // ここを自分のビュー名に変更
            //->subject('メールアドレスの確認')
            //->with(['url' => route('verification.verify', ['id' => $this->user->id, 'hash' => $this->user->getEmailVerificationHash()])]);
    //}
}
