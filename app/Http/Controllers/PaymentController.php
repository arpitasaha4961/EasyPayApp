<?php
namespace App\Http\Controllers;

use Stripe\Stripe;
use Stripe\Charge;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


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

            $user->is_active = true;
            $user->subscription_ends_at = now()->addMonth();
           

            DB::table('payments')->insert([
                'user_id' => $user->id,
                'amount' => 1000,
                'stripe_payment_id' => $charge->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $user->save();
            return redirect()->route('dashboard')->with('success', 'Payment successful, your subscription is active!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Payment failed. Please try again.']);
        }
    }
}
