<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function monthlyReport()
    {
        $user = Auth::user();

        // Fetch all payments made by the user in the last month
        $payments = $user->payments()
                         ->whereMonth('created_at', Carbon::now()->month)
                         ->get();

        return view('reports.monthlyReports', compact('payments'));
    }
}

