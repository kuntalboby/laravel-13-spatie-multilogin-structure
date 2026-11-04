<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        // $isCustomer = Auth::user()->hasRole('customer');
        $isCustomer = $user->hasRole('customer');
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $isCustomer
        ? redirect()->route('customer.login')
        : redirect()->route('admin.login');
    }
}