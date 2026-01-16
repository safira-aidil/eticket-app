<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-indigo-600" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="Auth::user()->role === 'admin' ? route('admin.dashboard') : route('dashboard')" 
                                :active="request()->routeIs('dashboard') || request()->routeIs('admin.dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    
                    @if(Auth::user()->role !== 'admin')
                    <x-nav-link :href="route('tickets.index')" :active="request()->routeIs('tickets.*')">
                        {{ __('Tiket Saya') }}
                    </x-nav-link>
                    @endif

                    @if(Auth::user()->role === 'admin')
                    <x-nav-link :href="route('admin.tickets.index')" :active="request()->routeIs('admin.tickets.*')" class="text-red-600 font-bold">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            {{ __('KELOLA TIKET MASUK') }}

                            {{-- PERBAIKAN: Mengambil data jumlah tiket WAITING secara otomatis --}}
                            @php
                                $waitingCount = \App\Models\Ticket::where('status', 'waiting')->count();
                            @endphp

                            @if($waitingCount > 0)
                                <span class="ms-2 px-2 py-0.5 text-[10px] font-black bg-red-600 text-white rounded-full shadow-sm">
                                    {{ $waitingCount }}
                                </span>
                            @endif
                        </span>
                    </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-6">
                <div class="flex items-center text-sm font-medium text-gray-500 bg-gray-50 px-4 py-1.5 rounded-full border border-gray-200">
                    <div class="w-2 h-2 {{ Auth::user()->role === 'admin' ? 'bg-blue-400' : 'bg-green-400' }} rounded-full mr-2 animate-pulse"></div>
                    <span class="font-bold text-gray-700 mr-1">{{ Auth::user()->name }}</span>
                    <span class="text-[10px] text-gray-400 uppercase tracking-tighter">({{ Auth::user()->role }})</span>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="inline-flex">
                    @csrf
                    <button type="submit" 
                        onclick="return confirm('Yakin ingin keluar aplikasi?')"
                        class="flex items-center text-sm font-bold text-red-500 hover:text-red-700 transition duration-150 ease-in-out">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        {{ __('Logout') }}
                    </button>
                </form>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-gray-100">
        <div class="pt-2 pb-3 space-y-1 bg-white">
            <x-responsive-nav-link :href="Auth::user()->role === 'admin' ? route('admin.dashboard') : route('dashboard')" 
                                   :active="request()->routeIs('dashboard') || request()->routeIs('admin.dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            
            @if(Auth::user()->role !== 'admin')
            <x-responsive-nav-link :href="route('tickets.index')" :active="request()->routeIs('tickets.*')">
                {{ __('Tiket Saya') }}
            </x-responsive-nav-link>
            @endif

            @if(Auth::user()->role === 'admin')
            <div class="border-t border-gray-100 my-1"></div>
            <x-responsive-nav-link :href="route('admin.tickets.index')" :active="request()->routeIs('admin.tickets.*')" class="text-red-600 font-bold bg-red-50 flex justify-between items-center">
                {{ __('KELOLA TIKET MASUK') }}
                @if($waitingCount > 0)
                    <span class="bg-red-500 text-white text-[10px] px-2 py-0.5 rounded-full">{{ $waitingCount }}</span>
                @endif
            </x-responsive-nav-link>
            @endif
            
            <div class="border-t border-gray-200 my-2"></div>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link :href="route('logout')"
                    onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600 font-bold">
                    {{ __('Logout (Keluar)') }}
                </x-responsive-nav-link>
            </form>
        </div>
    </div>
</nav>