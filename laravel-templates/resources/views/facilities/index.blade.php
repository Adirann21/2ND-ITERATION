@extends('layouts.app')

@section('title', 'Facilities - Campus Reserve')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Campus Facilities</h1>
            <p class="text-gray-600 mt-2">Browse and reserve available rooms and spaces</p>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
            <form method="GET" action="{{ route('facilities.index') }}" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                        placeholder="Search by name, building..." 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent">
                </div>
                <div class="w-full md:w-48">
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                    <select name="type" id="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent">
                        <option value="">All Types</option>
                        <option value="classroom" {{ request('type') == 'classroom' ? 'selected' : '' }}>Classroom</option>
                        <option value="laboratory" {{ request('type') == 'laboratory' ? 'selected' : '' }}>Laboratory</option>
                        <option value="conference_room" {{ request('type') == 'conference_room' ? 'selected' : '' }}>Conference Room</option>
                        <option value="auditorium" {{ request('type') == 'auditorium' ? 'selected' : '' }}>Auditorium</option>
                        <option value="sports_hall" {{ request('type') == 'sports_hall' ? 'selected' : '' }}>Sports Hall</option>
                        <option value="study_room" {{ request('type') == 'study_room' ? 'selected' : '' }}>Study Room</option>
                        <option value="other" {{ request('type') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div class="w-full md:w-40">
                    <label for="min_capacity" class="block text-sm font-medium text-gray-700 mb-1">Min Capacity</label>
                    <input type="number" name="min_capacity" id="min_capacity" value="{{ request('min_capacity') }}" 
                        placeholder="0" min="1"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="px-6 py-2 bg-black text-white rounded-lg hover:bg-gray-800 transition-colors">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Facilities Grid -->
        @if($facilities->isEmpty())
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <p class="text-gray-500">No facilities found matching your criteria</p>
                <a href="{{ route('facilities.index') }}" class="text-blue-600 hover:underline mt-2 inline-block">Clear filters</a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($facilities as $facility)
                    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="h-40 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                            @switch($facility->type)
                                @case('classroom')
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    @break
                                @case('laboratory')
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                    </svg>
                                    @break
                                @case('conference_room')
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    @break
                                @case('auditorium')
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                    @break
                                @case('sports_hall')
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                    </svg>
                                    @break
                                @case('study_room')
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    @break
                                @default
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                            @endswitch
                        </div>
                        <div class="p-5">
                            <div class="flex items-start justify-between mb-2">
                                <h3 class="font-semibold text-gray-900 text-lg">{{ $facility->name }}</h3>
                                @if($facility->requires_approval)
                                    <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Requires Approval</span>
                                @endif
                            </div>
                            <p class="text-sm text-gray-600 mb-2">{{ $facility->building }}{{ $facility->room_number ? ' - Room ' . $facility->room_number : '' }}</p>
                            <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    {{ $facility->capacity }} people
                                </span>
                                <span class="px-2 py-0.5 bg-gray-100 text-gray-700 rounded text-xs">{{ $facility->type_label }}</span>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('facilities.show', $facility) }}" class="flex-1 text-center px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-sm">
                                    View Details
                                </a>
                                <a href="{{ route('reservations.create', ['facility_id' => $facility->id]) }}" class="flex-1 text-center px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800 transition-colors text-sm">
                                    Reserve
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $facilities->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
