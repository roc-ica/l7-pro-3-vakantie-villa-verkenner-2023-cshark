<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
public function showLoginForm()
{
return view('pages.admin.login');
}

public function login(Request $request)
{
$request->validate([
'username' => 'required',
'password' => 'required',
]);

if (Auth::guard('admin')->attempt($request->only('username', 'password'))) {
return redirect()->intended('/admin/dashboard');
}

return back()->withErrors([
'username' => 'gebruikersnaam of wachtwoord is onjuist.',
]);
}

public function dashboard()
{
return view('pages.admin.dashboard');
}
}
