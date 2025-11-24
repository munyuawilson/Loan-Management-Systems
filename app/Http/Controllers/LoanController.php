<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Customer;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index()
    {
        $shop = Auth::user()->shop;
        $loans = $shop->loans()->with('customer')->latest()->get();
        return view('loans.index', compact('loans'));
    }

    public function create()
    {
        $shop = Auth::user()->shop;
        $customers = $shop->customers()->get();
        return view('loans.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'amount' => 'required|numeric|min:1',
            'description' => 'nullable|string',
        ]);

        $shop = Auth::user()->shop;

        $loan = Loan::create([
            'shop_id' => $shop->id,
            'customer_id' => $request->customer_id,
            'amount' => $request->amount,
            'balance' => $request->amount,
            'description' => $request->description,
            'status' => 'running',
        ]);

        return redirect()->route('loans.index')->with('success', 'Loan created successfully!');
    }

    public function show(Loan $loan)
    {
        $loan->load('payments', 'customer');
        return view('loans.show', compact('loan'));
    }

    public function edit(Loan $loan)
    {
        $shop = Auth::user()->shop;
        $customers = $shop->customers()->get();
        return view('loans.edit', compact('loan', 'customers'));
    }

    public function update(Request $request, Loan $loan)
    {

        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'amount' => 'required|numeric|min:1',
            'description' => 'nullable|string',
        ]);

        $loan->update($request->all());

        return redirect()->route('loans.index')->with('success', 'Loan updated successfully!');
    }

    public function destroy(Loan $loan)
    {
        $loan->delete();
        return redirect()->route('loans.index')->with('success', 'Loan deleted successfully!');
    }

    public function running()
    {
        $shop = Auth::user()->shop;
        $loans = $shop->loans()->where('status', 'running')->with('customer')->latest()->get();
        return view('loans.running', compact('loans'));
    }

    public function cleared()
    {
        $shop = Auth::user()->shop;
        $loans = $shop->loans()->where('status', 'cleared')->with('customer')->latest()->get();
        return view('loans.cleared', compact('loans'));
    }

    public function statement(Loan $loan)
    {
        $loan->load('payments', 'customer');
        return view('loans.statement', compact('loan'));
    }

    public function customerLoans()
    {
        $user = Auth::user();
        $loans = Loan::whereHas('customer', function($query) use ($user) {
            $query->where('email', $user->email);
        })->with('shop')->latest()->get();

        return view('customer.loans', compact('loans'));
    }
}