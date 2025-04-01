<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\AdminMiddleware;

class AdminController extends Controller
{
    // Using the middleware directly in the controller
    public function __construct()
    {
      
    }

    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('pages.admin.login');
    }

    public function login(Request $request)
{
    $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    $credentials = $request->only('username', 'password');
    
    // For debugging
    Log::info('Login attempt', ['username' => $request->username]);
    
    if (Auth::guard('admin')->attempt($credentials)) {
        $request->session()->regenerate();
        Log::info('Login successful');
        return redirect()->intended(route('admin.dashboard'));
    }

    Log::info('Login failed');
    return back()->withErrors([
        'username' => 'Username or password is incorrect.',
    ]);
}

    public function dashboard()
    {
        return view('pages.admin.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login');
    }
}