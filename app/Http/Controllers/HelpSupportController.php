<?php
// app/Http/Controllers/HelpSupportController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelpSupportController extends Controller
{
    public function index()
    {
        return view('help-support');
    }

    public function submitTicket(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
            'priority' => 'required|in:low,medium,high'
        ]);

        // will do this
        // 1. Save to database
        // 2. Send email notification
        // 3. Trigger support ticket

        return back()->with('success', 'Your support ticket has been submitted successfully! We\'ll get back to you within 24 hours.');
    }
}