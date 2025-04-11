<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\HouseRequestLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Handle the request for more information about a house
     */
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
        
        // Here you would typically send an email
        // For now, just return a success message
        // Example of sending email:
        /*
        Mail::send('emails.house-inquiry', [
            'email' => $validated['email'],
            'message' => $validated['message'],
            'house' => $house
        ], function($message) use ($validated) {
            $message->to('your@email.com', 'Your Name')
                ->subject('Nieuwe woningaanvraag: ' . $house->name);
            $message->from($validated['email']);
        });
        */
        
        return redirect()->back()->with('success', 'Uw aanvraag is succesvol verzonden. We nemen zo spoedig mogelijk contact met u op.');
    }
}