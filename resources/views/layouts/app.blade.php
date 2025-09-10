<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema Médico - MediCore')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }

        .sidebar-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        .sidebar-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
        }

        .sidebar-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        .notification-dot {
            position: absolute;
            top: -2px;
            right: -2px;
            width: 8px;
            height: 8px;
            background-color: #ef4444;
            border-radius: 50%;
        }

        .active-tab-indicator {
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 60%;
            background-color: white;
            border-radius: 0 4px 4px 0;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar - Verde médico profesional -->
        <div class="hidden md:flex md:w-64 md:flex-col">
            <div class="flex flex-col flex-grow bg-gradient-to-br from-emerald-800 via-teal-800 to-green-900 overflow-y-auto sidebar-scrollbar shadow-2xl border-r border-emerald-700/50">
                <!-- Logo -->
                <div class="flex items-center flex-shrink-0 px-4 py-6 bg-gradient-to-r from-emerald-600 to-teal-600">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-12 w-12 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center border border-white/20">
                                <i class="fas fa-heartbeat text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h1 class="text-xl font-bold text-white">MediCore</h1>
                            <p class="text-xs text-emerald-200">Sistema Hospitalario</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="mt-6 flex-1 px-3 space-y-2 pb-4">
                    <!-- Dashboard -->
                    <a href="{{ route('pacientes.index') }}"
                       class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl {{ request()->routeIs('pacientes.index') ? 'text-white bg-gradient-to-r from-emerald-500 to-teal-500 shadow-lg transition-all duration-300 relative' : 'text-emerald-100 hover:bg-white/10 hover:text-white backdrop-blur-sm transition-all duration-300' }}">
                        @if(request()->routeIs('pacientes.index'))
                            <div class="active-tab-indicator"></div>
                        @endif
                        <div class="mr-3 flex-shrink-0 h-5 w-5 {{ request()->routeIs('pacientes.index') ? 'text-white' : 'text-emerald-300' }}">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        Dashboard
                        @if(request()->routeIs('pacientes.index'))
                            <div class="ml-auto w-2 h-2 bg-white rounded-full"></div>
                        @endif
                    </a>

                    <!-- Pacientes -->
                    <div class="space-y-1">
                        <a href="{{ route('pacientes.index') }}"
                           class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl {{ request()->routeIs('pacientes.*') ? 'text-white bg-gradient-to-r from-emerald-500 to-teal-500 shadow-lg transition-all duration-300 relative' : 'text-emerald-100 hover:bg-white/10 hover:text-white backdrop-blur-sm transition-all duration-300' }}">
                            @if(request()->routeIs('pacientes.*'))
                                <div class="active-tab-indicator"></div>
                            @endif
                            <div class="mr-3 flex-shrink-0 h-5 w-5 {{ request()->routeIs('pacientes.*') ? 'text-white' : 'text-emerald-300' }}">
                                <i class="fas fa-user-injured"></i>
                            </div>
                            Pacientes
                            @if(request()->routeIs('pacientes.*'))
                                <i class="fas fa-chevron-down ml-auto text-xs"></i>
                            @endif
                        </a>

                        @if(request()->routeIs('pacientes.*'))
                            <div class="ml-8 space-y-1 border-l-2 border-emerald-400/30 pl-4">
                                <a href="{{ route('pacientes.index') }}"
                                   class="group flex items-center px-2 py-2 text-xs font-medium rounded-lg {{ request()->routeIs('pacientes.index') ? 'text-emerald-200 bg-emerald-500/20' : 'text-emerald-300 hover:text-emerald-200 hover:bg-emerald-500/10' }} transition-all duration-200">
                                    <div class="w-1.5 h-1.5 bg-current rounded-full mr-2"></div>
                                    Lista de Pacientes
                                </a>
                                <a href="{{ route('pacientes.create') }}"
                                   class="group flex items-center px-2 py-2 text-xs font-medium rounded-lg {{ request()->routeIs('pacientes.create') ? 'text-emerald-200 bg-emerald-500/20' : 'text-emerald-300 hover:text-emerald-200 hover:bg-emerald-500/10' }} transition-all duration-200">
                                    <div class="w-1.5 h-1.5 bg-current rounded-full mr-2"></div>
                                    Nuevo Paciente
                                </a>
                                <a href="#"
                                   class="group flex items-center px-2 py-2 text-xs font-medium rounded-lg text-emerald-300 hover:text-emerald-200 hover:bg-emerald-500/10 transition-all duration-200">
                                    <div class="w-1.5 h-1.5 bg-current rounded-full mr-2"></div>
                                    Historial Médico
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Doctores -->
                    <div class="space-y-1">
                        <a href="#"
                           class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl text-emerald-100 hover:bg-white/10 hover:text-white backdrop-blur-sm transition-all duration-300">
                            <div class="mr-3 flex-shrink-0 h-5 w-5 text-emerald-300">
                                <i class="fas fa-user-md"></i>
                            </div>
                            Doctores
                            <i class="fas fa-chevron-down ml-auto text-xs"></i>
                        </a>
                    </div>

                    <!-- Citas Médicas -->
                    <a href="#"
                       class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl text-emerald-100 hover:bg-white/10 hover:text-white backdrop-blur-sm transition-all duration-300 relative">
                        <div class="mr-3 flex-shrink-0 h-5 w-5 text-amber-400">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        Citas Médicas
                        <span class="ml-auto text-xs bg-gradient-to-r from-amber-500 to-orange-500 text-white px-2.5 py-1 rounded-full font-semibold">Próximamente</span>
                    </a>

                    <!-- Farmacia -->
                    <a href="#"
                       class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl text-emerald-100 hover:bg-white/10 hover:text-white backdrop-blur-sm transition-all duration-300">
                        <div class="mr-3 flex-shrink-0 h-5 w-5 text-blue-400">
                            <i class="fas fa-pills"></i>
                        </div>
                        Farmacia
                    </a>

                    <!-- Laboratorio -->
                    <a href="#"
                       class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl text-emerald-100 hover:bg-white/10 hover:text-white backdrop-blur-sm transition-all duration-300">
                        <div class="mr-3 flex-shrink-0 h-5 w-5 text-purple-400">
                            <i class="fas fa-vial"></i>
                        </div>
                        Laboratorio
                    </a>

                    <!-- Reportes -->
                    <a href="#"
                       class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl text-emerald-100 hover:bg-white/10 hover:text-white backdrop-blur-sm transition-all duration-300">
                        <div class="mr-3 flex-shrink-0 h-5 w-5 text-red-400">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        Reportes
                    </a>
                </nav>

                <!-- User Info -->
                <div class="flex-shrink-0 bg-gradient-to-r from-teal-900 to-emerald-900 p-4 border-t border-emerald-700/50">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 relative">
                            <div class="h-10 w-10 rounded-full bg-gradient-to-r from-emerald-500 to-teal-500 flex items-center justify-center shadow-lg border-2 border-white/20">
                                <span class="text-sm font-bold text-white">{{ substr(auth()->user()->name, 0, 2) }}</span>
                            </div>
                            <div class="notification-dot"></div>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-semibold text-white">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-emerald-300">{{ auth()->user()->username }}</p>
                        </div>
                        <div class="ml-2 relative">
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-gray-400 hover:text-red-400 p-2 rounded-lg hover:bg-white/10 transition-all duration-200" title="Cerrar Sesión">
                                    <i class="fas fa-sign-out-alt"></i>
                                </button>
                            </form>
                        </div>
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
                        <button class="md:hidden text-gray-500 hover:text-gray-700 mr-4">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <h1 class="text-2xl font-semibold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button class="relative p-2 text-gray-500 hover:text-gray-700">
                            <i class="fas fa-bell text-xl"></i>
                            <span class="absolute top-0 right-0 bg-red-500 text-white rounded-full text-xs w-5 h-5 flex items-center justify-center">3</span>
                        </button>
                        <button class="relative p-2 text-gray-500 hover:text-gray-700">
                            <i class="fas fa-envelope text-xl"></i>
                            <span class="absolute top-0 right-0 bg-blue-500 text-white rounded-full text-xs w-5 h-5 flex items-center justify-center">7</span>
                        </button>
                        <div class="text-sm text-gray-500">
                            <i class="far fa-clock mr-1"></i> {{ now()->format('d/m/Y H:i A') }}
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
                                <i class="fas fa-check-circle mr-2"></i>
                                <span>{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                <span>{{ session('error') }}</span>
                            </div>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script>
        // Script para manejar el menú desplegable
        document.addEventListener('DOMContentLoaded', function() {
            // Simular funcionalidad de menús desplegables
            const menuItems = document.querySelectorAll('.space-y-1 > a');
            menuItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    if (this.nextElementSibling && this.nextElementSibling.classList.contains('space-y-1')) {
                        e.preventDefault();
                        this.nextElementSibling.classList.toggle('hidden');
                        const icon = this.querySelector('.fa-chevron-down');
                        if (icon) {
                            icon.classList.toggle('rotate-180');
                        }
                    }
                });
            });

            // Actualizar la hora cada minuto
            function updateClock() {
                const now = new Date();
                const dateString = now.toLocaleDateString('es-ES', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric'
                });
                const timeString = now.toLocaleTimeString('es-ES', {
                    hour: '2-digit',
                    minute: '2-digit'
                });
                document.querySelector('.fa-clock').parentElement.textContent = `${dateString} ${timeString}`;
            }

            setInterval(updateClock, 60000);
        });
    </script>
</body>
</html>
