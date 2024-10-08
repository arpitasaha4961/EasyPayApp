@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h4>Welcome to your Dashboard, {{ auth()->user()->name }}!</h4>
                    <p>Subscription Status: {{ auth()->user()->is_active ? 'Active' : 'Inactive' }}</p>

                    <h5>Account Information</h5>
                    <ul>
                        <li>Email: {{ auth()->user()->email }}</li>
                        <li>Account Created: {{ auth()->user()->created_at->format('M d, Y') }}</li>
                        <li>Subscription Ends: {{ auth()->user()->subscription_ends_at ? auth()->user()->subscription_ends_at->format('M d, Y') : 'Not Subscribed' }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
