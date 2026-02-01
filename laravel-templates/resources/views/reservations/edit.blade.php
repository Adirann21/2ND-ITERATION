@extends('layouts.app')

@section('title', 'Edit Reservation - Campus Reserve')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('reservations.show', $reservation) }}" class="text-gray-600 hover:text-gray-900 flex items-center mb-4">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Reservation
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Edit Reservation</h1>
            <p class="text-gray-600 mt-2">Update your booking details</p>
        </div>

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <ul class="list-disc list-inside text-red-800 text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('reservations.update', $reservation) }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            @csrf
            @method('PUT')

            <!-- Facility Selection -->
            <div class="mb-6">
                <label for="facility_id" class="block text-sm font-medium text-gray-700 mb-2">Facility *</label>
                <select name="facility_id" id="facility_id" required 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent">
                    @foreach($facilities as $f)
                        <option value="{{ $f->id }}" {{ old('facility_id', $reservation->facility_id) == $f->id ? 'selected' : '' }}
                            data-capacity="{{ $f->capacity }}">
                            {{ $f->name }} ({{ $f->building }}) - Capacity: {{ $f->capacity }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Date -->
            <div class="mb-6">
                <label for="reservation_date" class="block text-sm font-medium text-gray-700 mb-2">Date *</label>
                <input type="date" name="reservation_date" id="reservation_date" required
                    value="{{ old('reservation_date', $reservation->reservation_date->format('Y-m-d')) }}" min="{{ date('Y-m-d') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent">
            </div>

            <!-- Time -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">Start Time *</label>
                    <input type="time" name="start_time" id="start_time" required
                        value="{{ old('start_time', \Carbon\Carbon::parse($reservation->start_time)->format('H:i')) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent">
                </div>
                <div>
                    <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">End Time *</label>
                    <input type="time" name="end_time" id="end_time" required
                        value="{{ old('end_time', \Carbon\Carbon::parse($reservation->end_time)->format('H:i')) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent">
                </div>
            </div>

            <!-- Purpose -->
            <div class="mb-6">
                <label for="purpose" class="block text-sm font-medium text-gray-700 mb-2">Purpose *</label>
                <input type="text" name="purpose" id="purpose" required
                    value="{{ old('purpose', $reservation->purpose) }}" placeholder="e.g., Team meeting, Class session, Study group..."
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent">
            </div>

            <!-- Attendees Count -->
            <div class="mb-6">
                <label for="attendees_count" class="block text-sm font-medium text-gray-700 mb-2">Expected Attendees</label>
                <input type="number" name="attendees_count" id="attendees_count" min="1"
                    value="{{ old('attendees_count', $reservation->attendees_count) }}" placeholder="Number of people"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent">
            </div>

            <!-- Notes -->
            <div class="mb-6">
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Additional Notes</label>
                <textarea name="notes" id="notes" rows="3" 
                    placeholder="Any special requirements or additional information..."
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent">{{ old('notes', $reservation->notes) }}</textarea>
            </div>

            <!-- Submit -->
            <div class="flex gap-4">
                <a href="{{ route('reservations.show', $reservation) }}" class="flex-1 text-center px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="flex-1 px-6 py-3 bg-black text-white rounded-lg hover:bg-gray-800 transition-colors">
                    Update Reservation
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
