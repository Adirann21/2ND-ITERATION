<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    /**
     * Display a listing of facilities.
     */
    public function index(Request $request)
    {
        $query = Facility::active();

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by capacity
        if ($request->filled('min_capacity')) {
            $query->where('capacity', '>=', $request->min_capacity);
        }

        // Search by name or building
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('building', 'like', "%{$search}%")
                    ->orWhere('room_number', 'like', "%{$search}%");
            });
        }

        $facilities = $query->orderBy('name')->paginate(12);

        return view('facilities.index', compact('facilities'));
    }

    /**
     * Display the specified facility.
     */
    public function show(Facility $facility)
    {
        $facility->load(['reservations' => function ($query) {
            $query->upcoming()->limit(10);
        }]);

        return view('facilities.show', compact('facility'));
    }

    /**
     * Get available time slots for a facility on a specific date.
     */
    public function availability(Request $request, Facility $facility)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
        ]);

        $date = $request->date;
        
        // Get all reservations for this date
        $reservations = $facility->reservations()
            ->where('reservation_date', $date)
            ->whereIn('status', ['pending', 'approved'])
            ->orderBy('start_time')
            ->get(['start_time', 'end_time']);

        return response()->json([
            'facility' => $facility->name,
            'date' => $date,
            'reservations' => $reservations,
        ]);
    }
}
