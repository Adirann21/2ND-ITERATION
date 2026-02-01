<?php

namespace App\Http\Controllers;

use App\Models\SavedCredential;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CredentialController extends Controller
{
    /**
     * Display a listing of the user's saved credentials.
     */
    public function index()
    {
        $credentials = SavedCredential::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('credentials.index', compact('credentials'));
    }

    /**
     * Show the form for creating a new credential.
     */
    public function create()
    {
        return view('credentials.create');
    }

    /**
     * Store a newly created credential in storage.
     * All data is automatically AES encrypted by the model.
     */
    public function store(Request $request)
    {
        $request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'site_url' => ['nullable', 'string', 'max:500'],
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:500'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        SavedCredential::create([
            'user_id' => Auth::id(),
            'site_name' => $request->site_name,
            'site_url' => $request->site_url,
            'username' => $request->username,
            'password' => $request->password,
            'notes' => $request->notes,
        ]);

        return redirect()->route('credentials.index')
            ->with('success', 'Credential saved successfully!');
    }

    /**
     * Display the specified credential.
     */
    public function show(SavedCredential $credential)
    {
        // Ensure user can only view their own credentials
        if ($credential->user_id !== Auth::id()) {
            abort(403);
        }

        return view('credentials.show', compact('credential'));
    }

    /**
     * Show the form for editing the specified credential.
     */
    public function edit(SavedCredential $credential)
    {
        // Ensure user can only edit their own credentials
        if ($credential->user_id !== Auth::id()) {
            abort(403);
        }

        return view('credentials.edit', compact('credential'));
    }

    /**
     * Update the specified credential in storage.
     */
    public function update(Request $request, SavedCredential $credential)
    {
        // Ensure user can only update their own credentials
        if ($credential->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'site_url' => ['nullable', 'string', 'max:500'],
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:500'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $credential->update([
            'site_name' => $request->site_name,
            'site_url' => $request->site_url,
            'username' => $request->username,
            'password' => $request->password,
            'notes' => $request->notes,
        ]);

        return redirect()->route('credentials.index')
            ->with('success', 'Credential updated successfully!');
    }

    /**
     * Remove the specified credential from storage.
     */
    public function destroy(SavedCredential $credential)
    {
        // Ensure user can only delete their own credentials
        if ($credential->user_id !== Auth::id()) {
            abort(403);
        }

        $credential->delete();

        return redirect()->route('credentials.index')
            ->with('success', 'Credential deleted successfully!');
    }

    /**
     * API endpoint to get decrypted password (for copy functionality)
     */
    public function getPassword(SavedCredential $credential)
    {
        // Ensure user can only access their own credentials
        if ($credential->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json([
            'password' => $credential->password
        ]);
    }
}
