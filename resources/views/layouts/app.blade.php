<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema Médico')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="hidden md:flex md:w-64 md:flex-col">
            <div class="flex flex-col flex-grow bg-gradient-to-br from-slate-800 via-blue-900 to-indigo-900 overflow-y-auto shadow-2xl border-r border-blue-800/50">
                <!-- Logo -->
                <div class="flex items-center flex-shrink-0 px-4 py-6 bg-gradient-to-r from-blue-600 to-indigo-600">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-12 w-12 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center border border-white/20">
                                <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h1 class="text-xl font-bold text-white">MediCore</h1>
                            <p class="text-xs text-blue-200">Sistema Hospitalario</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="mt-6 flex-1 px-3 space-y-2">
                    <!-- Dashboard -->
                    <a href="{{ route('pacientes.index') }}"
                       class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl {{ request()->routeIs('pacientes.index') ? 'bg-gradient-to-r from-blue-500 to-indigo-500 text-white shadow-lg' : 'text-blue-100 hover:bg-white/10 hover:text-white backdrop-blur-sm' }} transition-all duration-300 transform hover:scale-105">
                        <div class="mr-3 flex-shrink-0 h-5 w-5 {{ request()->routeIs('pacientes.index') ? 'text-white' : 'text-blue-300' }}">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v1H8V5z"/>
                            </svg>
                        </div>
                        Dashboard
                        @if(request()->routeIs('pacientes.index'))
                            <div class="ml-auto w-2 h-2 bg-white rounded-full"></div>
                        @endif
                    </a>

                    <!-- Pacientes -->
                    <div class="space-y-1">
                        <a href="{{ route('pacientes.index') }}"
                           class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl {{ request()->routeIs('pacientes.*') ? 'bg-gradient-to-r from-blue-500 to-indigo-500 text-white shadow-lg' : 'text-blue-100 hover:bg-white/10 hover:text-white backdrop-blur-sm' }} transition-all duration-300 transform hover:scale-105">
                            <div class="mr-3 flex-shrink-0 h-5 w-5 {{ request()->routeIs('pacientes.*') ? 'text-white' : 'text-blue-300' }}">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            Pacientes
                            @if(request()->routeIs('pacientes.*'))
                                <div class="ml-auto w-2 h-2 bg-white rounded-full"></div>
                            @endif
                        </a>
                        @if(request()->routeIs('pacientes.*'))
                            <div class="ml-8 space-y-1 border-l-2 border-blue-400/30 pl-4">
                                <a href="{{ route('pacientes.index') }}"
                                   class="group flex items-center px-2 py-2 text-xs font-medium rounded-lg {{ request()->routeIs('pacientes.index') ? 'text-blue-200 bg-blue-500/20' : 'text-blue-300 hover:text-blue-200 hover:bg-blue-500/10' }} transition-all duration-200">
                                    <div class="w-1.5 h-1.5 bg-current rounded-full mr-2"></div>
                                    Lista de Pacientes
                                </a>
                                <a href="{{ route('pacientes.create') }}"
                                   class="group flex items-center px-2 py-2 text-xs font-medium rounded-lg {{ request()->routeIs('pacientes.create') ? 'text-blue-200 bg-blue-500/20' : 'text-blue-300 hover:text-blue-200 hover:bg-blue-500/10' }} transition-all duration-200">
                                    <div class="w-1.5 h-1.5 bg-current rounded-full mr-2"></div>
                                    Nuevo Paciente
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Citas (placeholder) -->
                    <a href="#"
                       class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl text-blue-200 hover:bg-white/10 hover:text-white backdrop-blur-sm transition-all duration-300 transform hover:scale-105 opacity-70">
                        <div class="mr-3 flex-shrink-0 h-5 w-5 text-amber-400">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4m-6 8h6m-6 4h6m2-12H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2z"/>
                            </svg>
                        </div>
                        Citas Médicas
                        <span class="ml-auto text-xs bg-gradient-to-r from-amber-500 to-orange-500 text-white px-2.5 py-1 rounded-full font-semibold">Próximamente</span>
                    </a>

                    <!-- Admisiones (placeholder) -->
                    <a href="#"
                       class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl text-blue-200 hover:bg-white/10 hover:text-white backdrop-blur-sm transition-all duration-300 transform hover:scale-105 opacity-70">
                        <div class="mr-3 flex-shrink-0 h-5 w-5 text-purple-400">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        Admisiones
                        <span class="ml-auto text-xs bg-gradient-to-r from-purple-500 to-pink-500 text-white px-2.5 py-1 rounded-full font-semibold">Próximamente</span>
                    </a>
                </nav>

                <!-- User Info -->
                <div class="flex-shrink-0 bg-gradient-to-r from-indigo-900 to-blue-900 p-4 border-t border-blue-700/50">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-indigo-500 flex items-center justify-center shadow-lg border-2 border-white/20">
                                <span class="text-sm font-bold text-white">{{ substr(auth()->user()->name, 0, 2) }}</span>
                            </div>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-semibold text-white">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-blue-300">@{{ auth()->user()->username }}</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="ml-2">
                            @csrf
                            <button type="submit" class="text-gray-400 hover:text-red-400 p-2 rounded-lg hover:bg-white/10 transition-all duration-200" title="Cerrar Sesión">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Top header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center">
                        <button class="md:hidden text-gray-500 hover:text-gray-700">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                        <h1 class="text-2xl font-semibold text-gray-900 ml-2 md:ml-0">@yield('page-title', 'Dashboard')</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-sm text-gray-500">
                            {{ now()->format('d/m/Y H:i') }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page content -->
            <main class="flex-1 overflow-y-auto bg-gray-50">
                <div class="p-6">
                    <!-- Messages -->
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative">
                            <div class="flex items-center">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative">
                            <div class="flex items-center">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                <span>{{ session('error') }}</span>
                            </div>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>
</html>
