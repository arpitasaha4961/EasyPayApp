<?php
namespace App\Http\Controllers;

use Stripe\Stripe;
use Stripe\Charge;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function showPaymentForm()
    {
        return view('payment');
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'stripeToken' => 'required|string',
        ]);

        // Get the authenticated user
        $user = Auth::user();

        if (!$user) {
            return back()->withErrors(['error' => 'User not found or not authenticated.']);
        }


        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
        
            $charge = Charge::create([
                'amount' => 1000, // $10 in cents
                'currency' => 'usd',
                'source' => $request->stripeToken,
                'description' => 'Monthly Subscription',
            ]);

            // Update user status
            $user->is_active = true;
            $user->subscription_ends_at = now()->addMonth();
            $user->save();

        \DB::table('payments')->insert([
            'user_id' => $user->id,
            'amount' => 1000,
            'currency' => 'usd',
            'stripe_charge_id' => $charge->id,
            'description' => 'Monthly Subscription',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

            return redirect()->route('dashboard')->with('success', 'Payment successful, your subscription is active!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Payment failed. Please try again.']);
        }
    }
}
