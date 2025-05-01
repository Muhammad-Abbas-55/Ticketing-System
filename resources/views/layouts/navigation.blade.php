{{-- <nav x-data="{ open: false }" class="bg-white border-b border-gray-200 shadow-sm"> --}}
        <nav x-data="{ open: false }" style="background-color: #0d2346;" class="border-b border-gray-200 shadow-sm">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo + Title -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('dashboard') }}">
                    <span class="font-bold text-white text-xl hidden sm:block">Ticketing System</span>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden sm:flex space-x-6 items-center text-white">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="hover:text-gray-300 text-white">
                    <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                </x-nav-link>
            
                @can('view permissions')
                    <x-nav-link :href="route('permissions.index')" :active="request()->routeIs('permissions.index')" class="hover:text-gray-300 text-white">
                        <i class="fas fa-user-shield mr-1"></i> Permissions
                    </x-nav-link>
                @endcan
            
                @can('view roles')
                    <x-nav-link :href="route('roles.index')" :active="request()->routeIs('roles.index')" class="hover:text-gray-300 text-white">
                        <i class="fas fa-user-tag mr-1"></i> Roles
                    </x-nav-link>
                @endcan
            
                @can('view tickets')
                    <x-nav-link :href="route('tickets.index')" :active="request()->routeIs('tickets.index')" class="hover:text-gray-300 text-white">
                        <i class="fas fa-ticket-alt mr-1"></i> Tickets
                    </x-nav-link>
                @endcan
            
                @can('view users')
                    <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')" class="hover:text-gray-300 text-white">
                        <i class="fas fa-users mr-1"></i> Users
                    </x-nav-link>
                @endcan
            
                @can('view categories')
                    <x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.index')" class="hover:text-gray-300 text-white">
                        <i class="fas fa-folder-tree mr-1"></i> Categories
                    </x-nav-link>
                @endcan
            
                @can('view labels')
                    <x-nav-link :href="route('labels.index')" :active="request()->routeIs('labels.index')" class="hover:text-gray-300 text-white">
                        <i class="fas fa-tags mr-1"></i> Labels
                    </x-nav-link>
                @endcan
            </div>
            

            <!-- User Dropdown -->
            <div class="hidden sm:flex items-center space-x-4">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="flex items-center space-x-2 text-white hover:text-gray-800 transition font-medium">
                            <span>
                                <i class="fas fa-user-circle mr-1"></i>
                                {{ Auth::user()->name }} ({{ Auth::user()->roles()->pluck('name')->implode(', ') }})
                            </span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            <i class="fas fa-user-cog mr-1"></i> Profile
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="fas fa-sign-out-alt mr-1"></i> Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="sm:hidden flex items-center">
                <button @click="open = ! open"
                    class="p-2 rounded-md text-gray-500 hover:bg-gray-100 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="sm:hidden">
        <div class="px-4 pt-2 pb-3 space-y-2">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
            </x-responsive-nav-link>

            @can('view permissions')
                <x-responsive-nav-link :href="route('permissions.index')">
                    <i class="fas fa-user-shield mr-1"></i> Permissions
                </x-responsive-nav-link>
            @endcan

            @can('view roles')
                <x-responsive-nav-link :href="route('roles.index')">
                    <i class="fas fa-user-tag mr-1"></i> Roles
                </x-responsive-nav-link>
            @endcan

            @can('view tickets')
                <x-responsive-nav-link :href="route('tickets.index')">
                    <i class="fas fa-ticket-alt mr-1"></i> Tickets
                </x-responsive-nav-link>
            @endcan

            @can('view users')
                <x-responsive-nav-link :href="route('users.index')">
                    <i class="fas fa-users mr-1"></i> Users
                </x-responsive-nav-link>
            @endcan

            @can('view categories')
                <x-responsive-nav-link :href="route('categories.index')">
                    <i class="fas fa-folder-tree mr-1"></i> Categories
                </x-responsive-nav-link>
            @endcan

            @can('view labels')
                <x-responsive-nav-link :href="route('labels.index')">
                    <i class="fas fa-tags mr-1"></i> Labels
                </x-responsive-nav-link>
            @endcan
        </div>

        <!-- Mobile User Info -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4 text-gray-700">
                <div class="font-medium">{{ Auth::user()->name }}</div>
                <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    <i class="fas fa-user-cog mr-1"></i> Profile
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="fas fa-sign-out-alt mr-1"></i> Log Out
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
