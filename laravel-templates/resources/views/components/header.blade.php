<header class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between py-4">
            <a href="/" class="flex items-center">
                <div class="flex items-center border border-black px-2 py-1">
                    <span class="text-xs font-medium tracking-wide">CAMPUS</span>
                    <span class="bg-black text-white text-xs font-medium px-1 ml-1">RESERVE</span>
                </div>
            </a>

            <nav class="hidden md:flex items-center gap-8">
                <a href="/" class="text-sm font-medium hover:text-gray-600 transition-colors {{ request()->is('/') ? 'text-black' : 'text-gray-700' }}">HOME</a>
                <a href="{{ route('reserve') }}" class="text-sm font-medium hover:text-gray-600 transition-colors {{ request()->is('reservations*') ? 'text-black' : 'text-gray-700' }}">RESERVE</a>
                <a href="{{ route('facilities.index') }}" class="text-sm font-medium hover:text-gray-600 transition-colors {{ request()->is('facilities*') ? 'text-black' : 'text-gray-700' }}">FACILITIES</a>
                <a href="/about" class="text-sm font-medium hover:text-gray-600 transition-colors {{ request()->is('about') ? 'text-black' : 'text-gray-700' }}">ABOUT US</a>
                <a href="/contact" class="text-sm font-medium hover:text-gray-600 transition-colors {{ request()->is('contact') ? 'text-black' : 'text-gray-700' }}">CONTACT</a>
            </nav>

            <div class="flex items-center gap-3">
                @auth
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-1.5 text-sm font-medium bg-black text-white rounded-full hover:bg-gray-800 transition-colors">
                            Log Out
                        </button>
                    </form>
                @else
                    <a href="/signup" class="px-4 py-1.5 text-sm font-medium bg-black text-white rounded-full hover:bg-gray-800 transition-colors">Sign Up</a>
                    <a href="/login" class="px-4 py-1.5 text-sm font-medium bg-black text-white rounded-full hover:bg-gray-800 transition-colors">Log In</a>
                @endauth
            </div>
        </div>
    </div>
</header>
