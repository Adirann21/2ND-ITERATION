@extends('layouts.app')

@section('title', $facility->name . ' - Campus Reserve')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('facilities.index') }}" class="text-gray-600 hover:text-gray-900 flex items-center mb-4">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Facilities
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Hero -->
            <div class="h-56 bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                @switch($facility->type)
                    @case('classroom')
                        <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        @break
                    @case('laboratory')
                        <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                        </svg>
                        @break
                    @default
                        <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                @endswitch
            </div>

            <!-- Content -->
            <div class="p-8">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">{{ $facility->name }}</h1>
                        <p class="text-gray-600 mt-1">{{ $facility->building }}{{ $facility->room_number ? ' - Room ' . $facility->room_number : '' }}</p>
                    </div>
                    @if($facility->requires_approval)
                        <span class="px-3 py-1 text-sm bg-yellow-100 text-yellow-800 rounded-full">Requires Approval</span>
                    @endif
                </div>

                <div class="flex flex-wrap items-center gap-4 mb-6">
                    <span class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Capacity: {{ $facility->capacity }} people
                    </span>
                    <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">{{ $facility->type_label }}</span>
                </div>

                @if($facility->description)
                    <div class="mb-6">
                        <h2 class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">Description</h2>
                        <p class="text-gray-700">{{ $facility->description }}</p>
                    </div>
                @endif

                @if($facility->amenities && count($facility->amenities) > 0)
                    <div class="mb-8">
                        <h2 class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-3">Amenities</h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach($facility->amenities as $amenity)
                                <span class="px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg text-sm">{{ $amenity }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Upcoming Reservations -->
                @if($facility->reservations && $facility->reservations->count() > 0)
                    <div class="mb-8">
                        <h2 class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-3">Upcoming Bookings</h2>
                        <div class="space-y-2">
                            @foreach($facility->reservations as $res)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg text-sm">
                                    <span>{{ $res->reservation_date->format('M j, Y') }}</span>
                                    <span class="text-gray-600">{{ \Carbon\Carbon::parse($res->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($res->end_time)->format('g:i A') }}</span>
                                    <span class="px-2 py-0.5 rounded text-xs {{ $res->status_badge['class'] }}">{{ $res->status_badge['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Reserve Button -->
                <a href="{{ route('reservations.create', ['facility_id' => $facility->id]) }}" 
                    class="block w-full text-center px-6 py-3 bg-black text-white rounded-lg hover:bg-gray-800 transition-colors text-lg font-medium">
                    Reserve This Facility
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
