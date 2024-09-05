@extends('layouts.app')

@section('content')
<div class="card-header">Dashboard</div>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h4>Welcome, {{ auth()->user()->name }}!</h4>
                    <p>Subscription Status: {{ auth()->user()->is_active ? 'Active' : 'Inactive' }}</p>
                    <a href="{{ route('monthlyReport') }}" class="btn btn-primary mt-3">View Monthly Payment Report</a>

                    <h5>Account Information</h5>
                    <ul>
                        <li>Email: {{ auth()->user()->email }}</li>
                        <li>Account Created: {{ auth()->user()->created_at->format('M d, Y') }}</li>
                        <li>Subscription Ends: 
                            {{ auth()->user()->subscription_ends_at ? auth()->user()->subscription_ends_at->format('M d, Y') : 'Not Subscribed' }}
                        </li>
                    </ul>

                        <a href="{{ route('payment') }}" class="btn btn-primary">
                            Activate Subscription ($10/month)
                        </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
