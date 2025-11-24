<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Payment;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function create(Loan $loan)
    {
        return view('payments.create', compact('loan'));
    }

    public function store(Request $request, Loan $loan)
    {

        $request->validate([
            'amount_paid' => 'required|numeric|min:1|max:' . $loan->balance,
        ]);

        $payment = Payment::create([
            'loan_id' => $loan->id,
            'amount_paid' => $request->amount_paid,
            'remaining_balance' => $loan->balance - $request->amount_paid,
            'paid_at' => now(),
        ]);

        $loan->updateBalance();

        return redirect()->route('loans.show', $loan)->with('success', 'Payment recorded successfully!');
    }

    public function history(Loan $loan)
    {
       $payments = $loan->payments()->latest()->get();
        return view('payments.history', compact('loan', 'payments'));
    }

    public function index()
    {
        $shop = Auth::user()->shop;
        $payments = Payment::whereHas('loan', function($query) use ($shop) {
            $query->where('shop_id', $shop->id);
        })->with('loan.customer')->latest()->get();

        return view('payments.index', compact('payments'));
    }

    public function customerPayments()
    {
        $user = Auth::user();
        $payments = Payment::whereHas('loan.customer', function($query) use ($user) {
            $query->where('email', $user->email);
        })->with('loan.shop')->latest()->get();

        return view('customer.payments', compact('payments'));
    }
}