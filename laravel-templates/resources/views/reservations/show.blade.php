@extends('layouts.app')

@section('title', 'Reservation Details - Campus Reserve')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('reserve') }}" class="text-gray-600 hover:text-gray-900 flex items-center mb-4">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Reservations
            </a>
            <div class="flex items-center justify-between">
                <h1 class="text-3xl font-bold text-gray-900">Reservation Details</h1>
                <span class="px-3 py-1 text-sm font-medium rounded-full {{ $reservation->status_badge['class'] }}">
                    {{ $reservation->status_badge['label'] }}
                </span>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-800">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-800">
                {{ session('error') }}
            </div>
        @endif

        <!-- Reservation Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Facility Header -->
            <div class="bg-gradient-to-r from-gray-100 to-gray-200 p-6">
                <h2 class="text-2xl font-bold text-gray-900">{{ $reservation->facility->name }}</h2>
                <p class="text-gray-600">{{ $reservation->facility->building }}{{ $reservation->facility->room_number ? ' - Room ' . $reservation->facility->room_number : '' }}</p>
            </div>

            <!-- Details -->
            <div class="p-6 space-y-6">
                <!-- Date & Time -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">Date</h3>
                        <p class="text-lg font-semibold text-gray-900">{{ $reservation->reservation_date->format('l, F j, Y') }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">Time</h3>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ \Carbon\Carbon::parse($reservation->start_time)->format('g:i A') }} - 
                            {{ \Carbon\Carbon::parse($reservation->end_time)->format('g:i A') }}
                        </p>
                    </div>
                </div>

                <hr class="border-gray-200">

                <!-- Purpose -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">Purpose</h3>
                    <p class="text-gray-900">{{ $reservation->purpose }}</p>
                </div>

                @if($reservation->attendees_count)
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">Expected Attendees</h3>
                        <p class="text-gray-900">{{ $reservation->attendees_count }} people</p>
                    </div>
                @endif

                @if($reservation->notes)
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">Notes</h3>
                        <p class="text-gray-900">{{ $reservation->notes }}</p>
                    </div>
                @endif

                @if($reservation->admin_remarks)
                    <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <h3 class="text-sm font-medium text-blue-800 uppercase tracking-wide mb-2">Admin Remarks</h3>
                        <p class="text-blue-900">{{ $reservation->admin_remarks }}</p>
                    </div>
                @endif

                <hr class="border-gray-200">

                <!-- Facility Details -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-3">Facility Information</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500">Type:</span>
                            <span class="ml-2 text-gray-900">{{ $reservation->facility->type_label }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Capacity:</span>
                            <span class="ml-2 text-gray-900">{{ $reservation->facility->capacity }} people</span>
                        </div>
                    </div>
                    @if($reservation->facility->amenities)
                        <div class="mt-3">
                            <span class="text-gray-500 text-sm">Amenities:</span>
                            <div class="flex flex-wrap gap-2 mt-1">
                                @foreach($reservation->facility->amenities as $amenity)
                                    <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded">{{ $amenity }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Booking Info -->
                <div class="text-sm text-gray-500">
                    <p>Booked on: {{ $reservation->created_at->format('F j, Y \a\t g:i A') }}</p>
                </div>
            </div>

            <!-- Actions -->
            @if($reservation->canBeCancelled())
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex gap-4">
                    <a href="{{ route('reservations.edit', $reservation) }}" class="flex-1 text-center px-4 py-2 border border-gray-300 rounded-lg hover:bg-white transition-colors">
                        Edit Reservation
                    </a>
                    <form method="POST" action="{{ route('reservations.destroy', $reservation) }}" class="flex-1" 
                        onsubmit="return confirm('Are you sure you want to cancel this reservation?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 text-red-600 border border-red-300 rounded-lg hover:bg-red-50 transition-colors">
                            Cancel Reservation
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
