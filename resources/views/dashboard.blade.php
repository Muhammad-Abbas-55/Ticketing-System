<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="bg-gradient-to-br py-12 from-black via-blue-900 to-black min-h-screen flex flex-col justify-center items-center">
        @role('admin|super admin')
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Stat Card Component -->
                @php
                    $cards = [
                        [
                            'title' => 'Total Tickets',
                            'count' => $totalTickets,
                            'color' => 'blue',
                            'icon' => 'ticket',
                            'route' => route('tickets.index'),
                        ],
                        [
                            'title' => 'Total Users',
                            'count' => $totalUsers,
                            'color' => 'green',
                            'icon' => 'user',
                            'route' => route('users.index'),
                        ],
                        [
                            'title' => 'Total Categories',
                            'count' => $totalCategories,
                            'color' => 'purple',
                            'icon' => 'folder',
                            'route' => route('categories.index'),
                        ],
                        [
                            'title' => 'Total Labels',
                            'count' => $totalLabels,
                            'color' => 'yellow',
                            'icon' => 'tag',
                            'route' => route('labels.index'),
                        ],
                        [
                            'title' => 'Total Permissions',
                            'count' => $totalPermissions,
                            'color' => 'red',
                            'icon' => 'shield',
                            'route' => route('permissions.index'),
                        ],
                        [
                            'title' => 'Total Roles',
                            'count' => $totalRoles,
                            'color' => 'indigo',
                            'icon' => 'lock',
                            'route' => route('roles.index'),
                        ],
                    ];
                @endphp


                @foreach ($cards as $card)
                    <a href="{{ $card['route'] }}">
                        <div
                            class="bg-white shadow-md hover:shadow-xl rounded-2xl p-6 transition-all duration-300 border-t-4 border-{{ $card['color'] }}-500 hover:scale-105">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-700">{{ $card['title'] }}</h3>
                                    <p class="text-4xl font-bold text-{{ $card['color'] }}-600 mt-2">{{ $card['count'] }}</p>
                                </div>
                                <div class="text-4xl text-{{ $card['color'] }}-300">
                                    @if ($card['icon'] === 'ticket')
                                        🎫
                                    @elseif($card['icon'] === 'user')
                                        👤
                                    @elseif($card['icon'] === 'folder')
                                        🗂️
                                    @elseif($card['icon'] === 'tag')
                                        🏷️
                                    @elseif($card['icon'] === 'shield')
                                        🛡️
                                    @elseif($card['icon'] === 'lock')
                                        🔐
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach

            </div>
        @endrole
        @role('user|agent')
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-10">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Welcome Card -->
                    <div
                        class="bg-gradient-to-r from-blue-500 to-indigo-600 shadow-lg rounded-2xl p-8 text-white hover:scale-105 transition-all duration-300">
                        <div class="flex flex-col justify-center items-center text-center space-y-4">
                            <div class="text-5xl font-bold">
                                👋 Welcome
                            </div>
                            <div class="text-3xl font-semibold">
                                <h2 class="text-3xl font-bold">
                                    {{ auth()->user()->name }} 
                                    ({{ auth()->user()->roles->pluck('name')->map(fn($role) => ucfirst($role))->implode(', ') }})
                                </h2>
                                

                            </div>
                            <div class="text-sm mt-2 opacity-80">
                                Have a great {{ now()->format('A') == 'AM' ? 'morning' : 'evening' }}!
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endrole
    </div>
</x-app-layout>
