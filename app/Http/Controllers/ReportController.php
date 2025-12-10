<?php
// app/Http/Controllers/ReportController.php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Payment;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
  

    /**
     * Display main reports page
     */
    public function index()
    {
        return view('reports.index');
    }

    /**
     * Daily Collections Report
     */
    public function dailyCollections(Request $request)
    {
        $date = $request->input('date', now()->toDateString());
        $shopId = auth()->user()->shop->id;
        

        $collections = Payment::whereDate('paid_at', $date)
            ->whereHas('loan', function($query) use ($shopId) {
                $query->where('shop_id', $shopId);
            })
            ->with(['loan.customer'])
            ->orderBy('paid_at', 'desc')
            ->get();


        $total = $collections->sum('amount_paid');
      
        return view('reports.daily-collections', compact('collections', 'date', 'total'));
    }

    /**
     * Customer Statement
     */
    public function customerStatement(Request $request)
    {
        $customerId = $request->input('customer_id');
        $shopId = auth()->user()->shop->id;

        $customers = Customer::where('shop_id', $shopId)->get();

        if ($customerId) {
            $customer = Customer::where('id', $customerId)
                ->where('shop_id', $shopId)
                ->firstOrFail();

            $loans = $customer->loans()
                ->with(['payments' => function($query) {
                    $query->orderBy('paid_at', 'desc');
                }])
                ->orderBy('created_at', 'desc')
                ->get();

            // Calculate summary
            $totalLoans = $loans->count();
            $totalAmount = $loans->sum('amount');
            $totalPaid = $loans->sum(function($loan) {
                return $loan->payments->sum('amount_paid');
            });
            $totalBalance = $loans->sum('balance');

            return view('reports.customer-statement', compact('customers', 'customer', 'loans', 'totalLoans', 'totalAmount', 'totalPaid', 'totalBalance'));
        }

        return view('reports.customer-statement', compact('customers'));
    }

    /**
     * Running Loans Report
     */
    public function runningLoans()
    {
        $shopId = auth()->user()->shop->id;

        $loans = Loan::where('shop_id', $shopId)
            ->where('status', 'running')
            ->with('customer')
            ->orderBy('balance', 'desc')
            ->get();

        $totalBalance = $loans->sum('balance');
        $totalLoans = $loans->count();

        return view('reports.running-loans', compact('loans', 'totalBalance', 'totalLoans'));
    }

    /**
     * Ageing Analysis Report
     */
    public function ageingAnalysis()
    {
        $shopId = auth()->user()->shop->id;

        $loans = Loan::where('shop_id', $shopId)
            ->where('status', 'running')
            ->with('customer')
            ->get()
            ->map(function($loan) {
                $loan->days_outstanding = now()->diffInDays($loan->created_at);
                
                if ($loan->days_outstanding <= 30) {
                    $loan->age_category = 'Current (0-30 days)';
                    $loan->category_color = 'green';
                } elseif ($loan->days_outstanding <= 60) {
                    $loan->age_category = '31-60 days';
                    $loan->category_color = 'yellow';
                } elseif ($loan->days_outstanding <= 90) {
                    $loan->age_category = '61-90 days';
                    $loan->category_color = 'orange';
                } else {
                    $loan->age_category = 'Over 90 days';
                    $loan->category_color = 'red';
                }
                
                return $loan;
            });

        // Group by category for summary
        $summary = [
            'Current (0-30 days)' => ['count' => 0, 'amount' => 0],
            '31-60 days' => ['count' => 0, 'amount' => 0],
            '61-90 days' => ['count' => 0, 'amount' => 0],
            'Over 90 days' => ['count' => 0, 'amount' => 0],
        ];

        foreach ($loans as $loan) {
            $summary[$loan->age_category]['count']++;
            $summary[$loan->age_category]['amount'] += $loan->balance;
        }

        return view('reports.ageing-analysis', compact('loans', 'summary'));
    }

    /**
     * Payment Trends Report
     */
    public function paymentTrends(Request $request)
    {
        $period = $request->input('period', 'daily');
        $days = $request->input('days', 30);
        $shopId = auth()->user()->shop->id;

        $query = Payment::whereHas('loan', function($query) use ($shopId) {
                $query->where('shop_id', $shopId);
            });

        if ($period === 'daily') {
            $payments = $query->selectRaw('DATE(paid_at) as period, SUM(amount_paid) as total')
                ->groupBy('period')
                ->orderBy('period', 'desc')
                ->take($days)
                ->get()
                ->reverse();
        } elseif ($period === 'weekly') {
            $payments = $query->selectRaw('YEARWEEK(paid_at) as period, SUM(amount_paid) as total')
                ->groupBy('period')
                ->orderBy('period', 'desc')
                ->take($days/7)
                ->get()
                ->reverse()
                ->map(function($item) {
                    $year = substr($item->period, 0, 4);
                    $week = substr($item->period, 4);
                    $item->period = "Week {$week}, {$year}";
                    return $item;
                });
        } else { // monthly
            $payments = $query->selectRaw('DATE_FORMAT(paid_at, "%Y-%m") as period, SUM(amount_paid) as total')
                ->groupBy('period')
                ->orderBy('period', 'desc')
                ->take($days/30)
                ->get()
                ->reverse()
                ->map(function($item) {
                    $date = \Carbon\Carbon::createFromFormat('Y-m', $item->period);
                    $item->period = $date->format('F Y');
                    return $item;
                });
        }

        $totalAmount = $payments->sum('total');
        $averageAmount = $payments->count() > 0 ? $totalAmount / $payments->count() : 0;

        return view('reports.payment-trends', compact('payments', 'period', 'days', 'totalAmount', 'averageAmount'));
    }

    /**
     * Loan Portfolio Summary
     */
    public function loanPortfolio()
    {
        $shopId = auth()->user()->shop->id;

        $loans = Loan::where('shop_id', $shopId)
            ->with('customer')
            ->orderBy('created_at', 'desc')
            ->get();

        $summary = [
            'total_loans' => $loans->count(),
            'running_loans' => $loans->where('status', 'running')->count(),
            'cleared_loans' => $loans->where('status', 'cleared')->count(),
            'total_amount' => $loans->sum('amount'),
            'total_balance' => $loans->sum('balance'),
            'total_paid' => $loans->sum('amount') - $loans->sum('balance'),
            'avg_loan_size' => $loans->count() > 0 ? $loans->sum('amount') / $loans->count() : 0,
        ];

        // Top customers by loan amount
        $topCustomers = Customer::where('shop_id', $shopId)
            ->withSum('loans', 'amount')
            ->orderBy('loans_sum_amount', 'desc')
            ->take(5)
            ->get();

        // Recent payments
        $recentPayments = Payment::whereHas('loan', function($query) use ($shopId) {
                $query->where('shop_id', $shopId);
            })
            ->with('loan.customer')
            ->orderBy('paid_at', 'desc')
            ->take(10)
            ->get();

        return view('reports.loan-portfolio', compact('summary', 'loans', 'topCustomers', 'recentPayments'));
    }
}