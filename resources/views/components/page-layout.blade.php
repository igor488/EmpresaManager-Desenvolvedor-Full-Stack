@php
use Illuminate\Support\Facades\Route;
@endphp
<div>
    <!-- Navigation -->
    <nav class="bg-blue-800 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <h1 class="text-xl font-bold">Gestão de Grupos</h1>
                    </div>
                    <div class="hidden md:ml-6 md:flex md:space-x-4">
                        <a href="{{ route('dashboard') }}"
                           class="{{ request()->routeIs('dashboard') ? 'bg-blue-900' : '' }} px-3 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition">
                            Dashboard
                        </a>
                        <a href="{{ url('/livewire/grupos') }}"
                           class="{{ request()->is('livewire/grupos') ? 'bg-blue-900' : '' }} px-3 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition">
                            Grupos
                        </a>
                        <a href="{{ url('/livewire/bandeiras') }}"
                           class="{{ request()->is('livewire/bandeiras') ? 'bg-blue-900' : '' }} px-3 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition">
                            Bandeiras
                        </a>
                        <a href="{{ url('/livewire/unidades') }}"
                           class="{{ request()->is('livewire/unidades') ? 'bg-blue-900' : '' }} px-3 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition">
                            Unidades
                        </a>
                        <a href="{{ url('/livewire/colaboradores') }}"
                           class="{{ request()->is('livewire/colaboradores') ? 'bg-blue-900' : '' }} px-3 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition">
                            Colaboradores
                        </a>
                        <a href="{{ route('relatorio.colaboradores') }}"
                   class="{{ request()->routeIs('relatorio.colaboradores') ? 'bg-blue-900' : '' }} px-3 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition">
                        Relatórios
                         </a>
                    </div>
36                </div>
37
38                <div class="flex items-center">
39                    @auth
40                        <span class="mr-4">{{ auth()->user()->name }}</span>
41                        <form method="POST" action="{{ route('logout') }}">
42                            @csrf
43                            <button type="submit" class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-sm transition">
44                                Sair
45                            </button>
46                        </form>
47                    @endauth
48                </div>
49            </div>
50        </div>
51    </nav>

    <!-- Page Content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        {{ $slot }}
    </main>
</div>
