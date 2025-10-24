<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ url('/') }}">
                        <h1 class="text-xl font-bold text-blue-600 hover:text-blue-700 transition">🚌 BusTicket</h1>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    {{-- Tampil selalu --}}
                    <x-nav-link :href="route('landing')" :active="request()->routeIs('landing')">
                        {{ __('Beranda') }}
                    </x-nav-link>

                    {{-- Tampil hanya untuk user --}}
                    @auth
                        @if(Auth::user()->role === 'user')
                            <x-nav-link :href="route('user.tickets.show', 1)" :active="request()->is('user/tickets*')">
                                {{ __('Tiket Saya') }}
                            </x-nav-link>

                            <x-nav-link :href="route('user.booking_history')" :active="request()->is('user/booking_history')">
                                {{ __('Riwayat Pemesanan') }}
                            </x-nav-link>
                        @endif

                        {{-- Tampil hanya untuk admin --}}
                        @if(Auth::user()->role === 'admin')
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->is('admin/dashboard')">
                                {{ __('Dashboard Admin') }}
                            </x-nav-link>

                            <x-nav-link :href="route('admin.buses.index')" :active="request()->is('admin/buses*')">
                                {{ __('Manajemen Bus') }}
                            </x-nav-link>

                            <x-nav-link :href="route('admin.bookings.index')" :active="request()->is('admin/bookings*')">
                                {{ __('Manajemen Booking') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.routes.index')" :active="request()->is('admin/routes*')">
                                {{ __('Manajemen Route') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.schedules.index')" :active="request()->is('admin/schedules*')">
                                {{ __('Manajemen Schedule') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Right Side -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <!-- Settings Dropdown -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent 
                                text-sm leading-4 font-medium rounded-md text-gray-600 bg-white 
                                hover:text-blue-600 focus:outline-none transition duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 
                                            4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profil Saya') }}
                            </x-dropdown-link>

                            @if(Auth::user()->role === 'admin')
                                <x-dropdown-link :href="route('admin.dashboard')">
                                    {{ __('Halaman Admin') }}
                                </x-dropdown-link>
                            @endif

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Keluar') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endauth

                @guest
                    <div class="flex space-x-4">
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 font-medium transition">Login</a>
                        <a href="{{ route('register') }}" class="text-gray-600 hover:text-blue-600 font-medium transition">Register</a>
                    </div>
                @endguest
            </div>

            <!-- Hamburger Menu (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-blue-600 hover:bg-gray-100 focus:outline-none transition duration-150">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Menu (Mobile) -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('landing')" :active="request()->routeIs('landing')">
                {{ __('Beranda') }}
            </x-responsive-nav-link>

            @auth
                @if(Auth::user()->role === 'user')
                    <x-responsive-nav-link :href="route('user.tickets.show', 1)" :active="request()->is('user/tickets*')">
                        {{ __('Tiket Saya') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('user.booking_history')" :active="request()->is('user/booking_history')">
                        {{ __('Riwayat Pemesanan') }}
                    </x-responsive-nav-link>
                @endif

                @if(Auth::user()->role === 'admin')
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->is('admin/dashboard')">
                        {{ __('Dashboard Admin') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.buses.index')" :active="request()->is('admin/buses*')">
                        {{ __('Manajemen Bus') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.bookings.index')" :active="request()->is('admin/bookings*')">
                        {{ __('Manajemen Booking') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.routes.index')" :active="request()->is('admin/routes*')">
                        {{ __('Manajemen Route') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.schedules.index')" :active="request()->is('admin/schedules*')">
                        {{ __('Manajemen Schedule') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <!-- Responsive Auth Menu -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profil Saya') }}
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Keluar') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @endauth

            @guest
                <div class="px-4 py-3">
                    <a href="{{ route('login') }}" class="block text-gray-600 font-medium hover:text-blue-600 transition">Login</a>
                    <a href="{{ route('register') }}" class="block text-gray-600 font-medium hover:text-blue-600 transition">Register</a>
                </div>
            @endguest
        </div>
    </div>
</nav>
