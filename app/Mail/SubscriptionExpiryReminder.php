<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscriptionExpiryReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Your Subscription will be expire within two days')
                    ->view('emails.subscription_reminder')
                    ->with([
                        'userName' => $this->user->name,
                        'expiryDate' => $this->user->subscription_ends_at->format('M d, Y'),
                    ]);
    }
}
