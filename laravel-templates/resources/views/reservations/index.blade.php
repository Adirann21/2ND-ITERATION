@extends('layouts.app')

@section('title', 'My Reservations - Campus Reserve')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">My Reservations</h1>
                <p class="text-gray-600 mt-2">Manage your facility bookings</p>
            </div>
            <a href="{{ route('facilities.index') }}" class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                New Reservation
            </a>
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

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Upcoming</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $upcomingReservations->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-lg">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Pending Approval</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $upcomingReservations->where('status', 'pending')->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Completed</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $pastReservations->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Reservations -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Upcoming Reservations</h2>
            
            @if($upcomingReservations->isEmpty())
                <div class="text-center py-8 text-gray-500">
                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p>No upcoming reservations</p>
                    <a href="{{ route('facilities.index') }}" class="text-blue-600 hover:underline mt-2 inline-block">Browse facilities to make a reservation</a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($upcomingReservations as $reservation)
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="font-semibold text-gray-900">{{ $reservation->facility->name }}</h3>
                                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $reservation->status_badge['class'] }}">
                                            {{ $reservation->status_badge['label'] }}
                                        </span>
                                    </div>
                                    <div class="text-sm text-gray-600 space-y-1">
                                        <p><span class="font-medium">Date:</span> {{ $reservation->reservation_date->format('l, F j, Y') }}</p>
                                        <p><span class="font-medium">Time:</span> {{ \Carbon\Carbon::parse($reservation->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($reservation->end_time)->format('g:i A') }}</p>
                                        <p><span class="font-medium">Purpose:</span> {{ $reservation->purpose }}</p>
                                    </div>
                                </div>
                                <div class="mt-4 sm:mt-0 flex gap-2">
                                    <a href="{{ route('reservations.show', $reservation) }}" class="px-4 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                        View Details
                                    </a>
                                    @if($reservation->canBeCancelled())
                                        <form method="POST" action="{{ route('reservations.destroy', $reservation) }}" onsubmit="return confirm('Are you sure you want to cancel this reservation?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-4 py-2 text-sm text-red-600 border border-red-300 rounded-lg hover:bg-red-50 transition-colors">
                                                Cancel
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Past Reservations -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Past Reservations</h2>
            
            @if($pastReservations->isEmpty())
                <div class="text-center py-8 text-gray-500">
                    <p>No past reservations</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($pastReservations as $reservation)
                        <div class="border border-gray-200 rounded-lg p-4 opacity-75">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="font-semibold text-gray-900">{{ $reservation->facility->name }}</h3>
                                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $reservation->status_badge['class'] }}">
                                            {{ $reservation->status_badge['label'] }}
                                        </span>
                                    </div>
                                    <div class="text-sm text-gray-600">
                                        <p>{{ $reservation->reservation_date->format('F j, Y') }} | {{ \Carbon\Carbon::parse($reservation->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($reservation->end_time)->format('g:i A') }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('reservations.show', $reservation) }}" class="mt-4 sm:mt-0 px-4 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                    View
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
