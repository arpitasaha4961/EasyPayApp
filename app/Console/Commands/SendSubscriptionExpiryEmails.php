<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Carbon\Carbon;

class SendSubscriptionExpiryEmails extends Command
{
    // Command name
    protected $signature = 'send:subscription-emails';
    protected $description = 'Send email reminders to users whose subscriptions will expire in 2 days';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Find users whose subscription ends in 2 days
        $usersToNotify = User::where('is_active', true)
            ->whereDate('subscription_ends_at', Carbon::now()->addDays(2)->toDateString())
            ->get();

        foreach ($usersToNotify as $user) {
            // Send reminder email
            Mail::to($user->email)->send(new \App\Mail\SubscriptionExpiryReminder($user));
            $this->info("Reminder email sent to: " . $user->email);
        }
    }
}
