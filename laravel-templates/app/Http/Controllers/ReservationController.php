<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Display a listing of user's reservations.
     */
    public function index()
    {
        $upcomingReservations = Auth::user()->reservations()
            ->with('facility')
            ->upcoming()
            ->get();

        $pastReservations = Auth::user()->reservations()
            ->with('facility')
            ->completed()
            ->orderByDesc('reservation_date')
            ->limit(10)
            ->get();

        return view('reservations.index', compact('upcomingReservations', 'pastReservations'));
    }

    /**
     * Show the form for creating a new reservation.
     */
    public function create(Request $request)
    {
        $facility = null;
        if ($request->filled('facility_id')) {
            $facility = Facility::active()->findOrFail($request->facility_id);
        }

        $facilities = Facility::active()->orderBy('name')->get();

        return view('reservations.create', compact('facilities', 'facility'));
    }

    /**
     * Store a newly created reservation.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'facility_id' => 'required|exists:facilities,id',
            'reservation_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'purpose' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
            'attendees_count' => 'nullable|integer|min:1',
        ]);

        $facility = Facility::findOrFail($validated['facility_id']);

        // Check availability
        if (!$facility->isAvailable($validated['reservation_date'], $validated['start_time'], $validated['end_time'])) {
            return back()
                ->withInput()
                ->withErrors(['time' => 'This time slot is already booked. Please choose a different time.']);
        }

        // Check attendees count doesn't exceed capacity
        if ($validated['attendees_count'] && $validated['attendees_count'] > $facility->capacity) {
            return back()
                ->withInput()
                ->withErrors(['attendees_count' => "The number of attendees exceeds the facility's capacity of {$facility->capacity}."]);
        }

        $reservation = Auth::user()->reservations()->create([
            'facility_id' => $validated['facility_id'],
            'reservation_date' => $validated['reservation_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'purpose' => $validated['purpose'],
            'notes' => $validated['notes'] ?? null,
            'attendees_count' => $validated['attendees_count'] ?? null,
            'status' => $facility->requires_approval ? 'pending' : 'approved',
        ]);

        $message = $facility->requires_approval 
            ? 'Reservation submitted! Awaiting approval.'
            : 'Reservation confirmed successfully!';

        return redirect()->route('reservations.show', $reservation)->with('success', $message);
    }

    /**
     * Display the specified reservation.
     */
    public function show(Reservation $reservation)
    {
        // Ensure user can only view their own reservations
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        $reservation->load('facility');

        return view('reservations.show', compact('reservation'));
    }

    /**
     * Show the form for editing the reservation.
     */
    public function edit(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        if (!$reservation->canBeCancelled()) {
            return back()->with('error', 'This reservation cannot be edited.');
        }

        $facilities = Facility::active()->orderBy('name')->get();

        return view('reservations.edit', compact('reservation', 'facilities'));
    }

    /**
     * Update the specified reservation.
     */
    public function update(Request $request, Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        if (!$reservation->canBeCancelled()) {
            return back()->with('error', 'This reservation cannot be updated.');
        }

        $validated = $request->validate([
            'facility_id' => 'required|exists:facilities,id',
            'reservation_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'purpose' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
            'attendees_count' => 'nullable|integer|min:1',
        ]);

        $facility = Facility::findOrFail($validated['facility_id']);

        // Check availability (excluding current reservation)
        if (!$facility->isAvailable($validated['reservation_date'], $validated['start_time'], $validated['end_time'], $reservation->id)) {
            return back()
                ->withInput()
                ->withErrors(['time' => 'This time slot is already booked. Please choose a different time.']);
        }

        $reservation->update([
            'facility_id' => $validated['facility_id'],
            'reservation_date' => $validated['reservation_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'purpose' => $validated['purpose'],
            'notes' => $validated['notes'] ?? null,
            'attendees_count' => $validated['attendees_count'] ?? null,
            'status' => $facility->requires_approval ? 'pending' : 'approved',
        ]);

        return redirect()->route('reservations.show', $reservation)->with('success', 'Reservation updated successfully!');
    }

    /**
     * Cancel the specified reservation.
     */
    public function destroy(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        if (!$reservation->canBeCancelled()) {
            return back()->with('error', 'This reservation cannot be cancelled.');
        }

        $reservation->update(['status' => 'cancelled']);

        return redirect()->route('reservations.index')->with('success', 'Reservation cancelled successfully.');
    }
}
