@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Subscription Payment</h2>

    <form action="{{ route('processPayment') }}" method="POST" id="payment-form">
        @csrf
        <input type="hidden" name="stripeToken" id="stripeToken">
        
        <script src="https://checkout.stripe.com/checkout.js"
            class="stripe-button"
            data-key="{{ env('STRIPE_KEY') }}"
            data-amount="1000"  <!-- $10 -->
            data-name="Laravel Subscription"
            data-description="Monthly Subscription"
            data-currency="usd">
        </script>
    </form>

    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif
</div>
@endsection
