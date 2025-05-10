<?php

namespace App\Http\Controllers;

use App\Models\HouseRequestLog;
use Illuminate\Http\Request;

class RequestsController extends Controller
{
    /**
     * Display a listing of the requests
     */
    public function index()
    {
        $requests = HouseRequestLog::with('house')->latest()->get();
        return view('pages.admin.requests.index', compact('requests'));
    }

    /**
     * Mark a request as completed
     */
    public function markCompleted(HouseRequestLog $request)
    {
        $request->update(['completed' => true]);
        return redirect()->back()->with('success', 'Aanvraag gemarkeerd als afgehandeld.');
    }

    /**
     * Mark a request as pending
     */
    public function markPending(HouseRequestLog $request)
    {
        $request->update(['completed' => false]);
        return redirect()->back()->with('success', 'Aanvraag gemarkeerd als in behandeling.');
    }

    /**
     * Delete a request
     */
    public function destroy(HouseRequestLog $request)
    {
        $request->delete();
        return redirect()->back()->with('success', 'Aanvraag succesvol verwijderd.');
    }
}
