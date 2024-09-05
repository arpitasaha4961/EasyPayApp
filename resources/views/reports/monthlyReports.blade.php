@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Monthly Payment Report</h1>

    @if($payments->isEmpty())
        <p>No payments made this month.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Transaction ID</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                    <tr>
                        <td>{{ $payment->created_at->format('M d, Y') }}</td>
                        <td>${{ number_format($payment->amount, 2) }}</td>
                        <td>{{ $payment->transaction_id }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
