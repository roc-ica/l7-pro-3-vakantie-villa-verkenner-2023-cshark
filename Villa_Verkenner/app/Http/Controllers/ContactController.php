<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\HouseRequestLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function sendInfo(Request $request, House $house)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);
        
        // Store the request in the database
        HouseRequestLog::create([
            'house_object_id' => $house->id,
            'email' => $validated['email'],
            'message' => $validated['message'],
            'completed' => false,
        ]);
    
        
        return redirect()->back()->with('success', 'Uw aanvraag is succesvol verzonden. We nemen zo spoedig mogelijk contact met u op.');
    }
}