<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $shop = $user->shop;
        
        // If user doesn't have a shop yet, redirect to create shop
        if (!$shop) {
            return redirect()->route('shop.create');
        }

        $stats = [
            'total_customers' => $shop->customers()->count(),
            'running_loans' => $shop->loans()->where('status', 'running')->count(),
            'cleared_loans' => $shop->loans()->where('status', 'cleared')->count(),
            'total_balance' => $shop->loans()->sum('balance'),
        ];

        return view('dashboard', compact('shop', 'stats'));
    }

    public function create()
    {
        return view('shop.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'shop_name' => 'required|string|max:255',
            'shop_phone' => 'required|string|max:20',
            'address' => 'required|string',
        ]);

        $shop = Shop::create([
            'owner_id' => Auth::id(),
            'shop_name' => $request->shop_name,
            'shop_phone' => $request->shop_phone,
            'address' => $request->address,
        ]);

        return redirect()->route('shop.dashboard')->with('success', 'Shop created successfully!');
    }
}