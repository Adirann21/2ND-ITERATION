@extends('layouts.app')

@section('title', 'New Reservation - Campus Reserve')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('facilities.index') }}" class="text-gray-600 hover:text-gray-900 flex items-center mb-4">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Facilities
            </a>
            <h1 class="text-3xl font-bold text-gray-900">New Reservation</h1>
            <p class="text-gray-600 mt-2">Fill in the details to book a facility</p>
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

        <form method="POST" action="{{ route('reservations.store') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            @csrf

            <!-- Facility Selection -->
            <div class="mb-6">
                <label for="facility_id" class="block text-sm font-medium text-gray-700 mb-2">Facility *</label>
                <select name="facility_id" id="facility_id" required 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent">
                    <option value="">Select a facility</option>
                    @foreach($facilities as $f)
                        <option value="{{ $f->id }}" {{ (old('facility_id') ?? ($facility->id ?? '')) == $f->id ? 'selected' : '' }}
                            data-capacity="{{ $f->capacity }}" data-requires-approval="{{ $f->requires_approval ? 'true' : 'false' }}">
                            {{ $f->name }} ({{ $f->building }}) - Capacity: {{ $f->capacity }}
                        </option>
                    @endforeach
                </select>
            </div>

            @if($facility && $facility->requires_approval)
                <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <p class="text-yellow-800 text-sm flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        This facility requires admin approval. Your reservation will be pending until approved.
                    </p>
                </div>
            @endif

            <!-- Date -->
            <div class="mb-6">
                <label for="reservation_date" class="block text-sm font-medium text-gray-700 mb-2">Date *</label>
                <input type="date" name="reservation_date" id="reservation_date" required
                    value="{{ old('reservation_date') }}" min="{{ date('Y-m-d') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent">
            </div>

            <!-- Time -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">Start Time *</label>
                    <input type="time" name="start_time" id="start_time" required
                        value="{{ old('start_time') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent">
                </div>
                <div>
                    <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">End Time *</label>
                    <input type="time" name="end_time" id="end_time" required
                        value="{{ old('end_time') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent">
                </div>
            </div>

            <!-- Purpose -->
            <div class="mb-6">
                <label for="purpose" class="block text-sm font-medium text-gray-700 mb-2">Purpose *</label>
                <input type="text" name="purpose" id="purpose" required
                    value="{{ old('purpose') }}" placeholder="e.g., Team meeting, Class session, Study group..."
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent">
            </div>

            <!-- Attendees Count -->
            <div class="mb-6">
                <label for="attendees_count" class="block text-sm font-medium text-gray-700 mb-2">Expected Attendees</label>
                <input type="number" name="attendees_count" id="attendees_count" min="1"
                    value="{{ old('attendees_count') }}" placeholder="Number of people"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent">
                <p class="text-sm text-gray-500 mt-1" id="capacity-hint">
                    @if($facility)
                        Maximum capacity: {{ $facility->capacity }} people
                    @else
                        Select a facility to see capacity
                    @endif
                </p>
            </div>

            <!-- Notes -->
            <div class="mb-6">
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Additional Notes</label>
                <textarea name="notes" id="notes" rows="3" 
                    placeholder="Any special requirements or additional information..."
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent">{{ old('notes') }}</textarea>
            </div>

            <!-- Submit -->
            <div class="flex gap-4">
                <a href="{{ route('facilities.index') }}" class="flex-1 text-center px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="flex-1 px-6 py-3 bg-black text-white rounded-lg hover:bg-gray-800 transition-colors">
                    Submit Reservation
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('facility_id').addEventListener('change', function() {
        const option = this.options[this.selectedIndex];
        const capacity = option.dataset.capacity;
        const requiresApproval = option.dataset.requiresApproval === 'true';
        
        if (capacity) {
            document.getElementById('capacity-hint').textContent = 'Maximum capacity: ' + capacity + ' people';
            document.getElementById('attendees_count').max = capacity;
        } else {
            document.getElementById('capacity-hint').textContent = 'Select a facility to see capacity';
        }
    });
</script>
@endsection
