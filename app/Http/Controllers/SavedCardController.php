<?php

namespace App\Http\Controllers;

use App\Models\SavedCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedCardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display user's saved cards
     */
    public function index()
    {
        $savedCards = Auth::user()->savedCards()->orderBy('is_default', 'desc')->get();
        return view('users.payment.saved-cards', compact('savedCards'));
    }

    /**
     * Store a new saved card
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'card_holder' => 'required|string|max:100',
            'card_number' => 'required|string|size:16',
            'card_brand' => 'nullable|string|max:50',
            'expiry_month' => 'required|string|size:2',
            'expiry_year' => 'required|string|size:4',
            'is_default' => 'boolean',
        ]);

        // If this card is set as default, remove default from other cards
        if ($request->is_default) {
            Auth::user()->savedCards()->update(['is_default' => false]);
        }

        // Only store last 4 digits for security
        $cardLastFour = substr($validated['card_number'], -4);

        $savedCard = Auth::user()->savedCards()->create([
            'card_holder' => $validated['card_holder'],
            'card_last_four' => $cardLastFour,
            'card_brand' => $validated['card_brand'] ?? null,
            'expiry_month' => $validated['expiry_month'],
            'expiry_year' => $validated['expiry_year'],
            'is_default' => $request->is_default ?? false,
        ]);

        return redirect()->back()->with('success', 'Карт амжилттай хадгалагдлаа');
    }

    /**
     * Set a card as default
     */
    public function setDefault($id)
    {
        $card = SavedCard::where('user_id', Auth::id())->findOrFail($id);

        // Remove default from all cards
        Auth::user()->savedCards()->update(['is_default' => false]);

        // Set this card as default
        $card->update(['is_default' => true]);

        return redirect()->back()->with('success', 'Үндсэн карт солигдлоо');
    }

    /**
     * Delete a saved card
     */
    public function destroy($id)
    {
        $card = SavedCard::where('user_id', Auth::id())->findOrFail($id);
        $card->delete();

        return redirect()->back()->with('success', 'Карт устгагдлаа');
    }
}
