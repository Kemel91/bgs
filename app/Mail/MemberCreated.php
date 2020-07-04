<?php

namespace App\Mail;

use App\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MemberCreated extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $member;

    /**
     * Create a new message instance.
     *
     * @param Member $member
     */
    public function __construct(Member $member)
    {
        $this->member = $member;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.member');
    }
}
