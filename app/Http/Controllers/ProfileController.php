<?php
// app/Http/Controllers/ProfileController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
  

    /**
     * Show the user's profile
     */
    public function edit()
    {
        $user = auth()->user();
        $shop = $user->shop;
        
        return view('profile.edit', compact('user', 'shop'));
    }

    /**
     * Update the user's profile information
     */
    public function update(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $validated['profile_photo'] = $path;
        }

        $user->update($validated);

        return back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Update the user's password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = auth()->user();

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password updated successfully!');
    }

    /**
     * Update shop information
     */
    public function updateShop(Request $request)
    {
        $user = auth()->user();
        
        if (!$user->shop) {
            return back()->withErrors(['shop' => 'Shop not found']);
        }

        $validated = $request->validate([
            'shop_name' => ['required', 'string', 'max:255'],
            'shop_address' => ['nullable', 'string', 'max:255'],
            'shop_phone' => ['nullable', 'string', 'max:20'],
            'shop_email' => ['nullable', 'email', 'max:255'],
            'shop_logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'currency' => ['nullable', 'string', 'max:10'],
            'timezone' => ['nullable', 'string', 'max:50'],
        ]);

        // Handle shop logo upload
        if ($request->hasFile('shop_logo')) {
            $path = $request->file('shop_logo')->store('shop-logos', 'public');
            $validated['logo'] = $path;
        }

        $user->shop->update($validated);

        return back()->with('success', 'Shop information updated successfully!');
    }

    /**
     * Delete profile photo
     */
    public function deleteProfilePhoto()
    {
        $user = auth()->user();
        
        if ($user->profile_photo) {
            // Delete file from storage (optional)
            // Storage::disk('public')->delete($user->profile_photo);
            
            $user->update(['profile_photo' => null]);
        }

        return back()->with('success', 'Profile photo removed successfully!');
    }

    /**
     * Delete shop logo
     */
    public function deleteShopLogo()
    {
        $user = auth()->user();
        
        if ($user->shop && $user->shop->logo) {
            // Delete file from storage (optional)
            // Storage::disk('public')->delete($user->shop->logo);
            
            $user->shop->update(['logo' => null]);
        }

        return back()->with('success', 'Shop logo removed successfully!');
    }
}