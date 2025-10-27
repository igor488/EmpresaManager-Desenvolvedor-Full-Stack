<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($title ?? 'Sistema de Gestão'); ?></title>

    <!-- Fontes Google -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Ícones -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>


    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .sidebar-gradient {
            background: linear-gradient(180deg, #1e3a8a 0%, #1e40af 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
            border: 1px solid #e5e7eb;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .nav-item {
            transition: all 0.3s ease;
            border-radius: 0.5rem;
            margin: 0.25rem 0;
        }
        .nav-item:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }
        .nav-item.active {
            background: rgba(255, 255, 255, 0.15);
            border-left: 4px solid #60a5fa;
        }
        [x-cloak] {
            display: none !important;
        }

        /* Estilos para o sidebar mobile */
        .sidebar-mobile {
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
        }
        .sidebar-mobile.open {
            transform: translateX(0);
        }
    </style>
</head>
<body class="bg-gray-50 font-sans" style="font-family: 'Inter', sans-serif;">
    <!-- Layout Principal -->
    <div class="min-h-screen flex">
        <!-- Overlay Mobile -->
        <div id="mobileOverlay"
             class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"
             onclick="closeSidebar()">
        </div>

        <!-- Sidebar - Versão SIMPLIFICADA sem Alpine -->
        <div id="sidebar"
             class="sidebar-gradient w-64 min-h-screen shadow-xl fixed left-0 top-0 z-50 lg:z-40 sidebar-mobile lg:translate-x-0">

            <!-- Logo e Botão Fechar Mobile -->
            <div class="p-4 md:p-6 border-b border-blue-700 flex justify-between items-center lg:block">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 md:w-10 md:h-10 bg-white rounded-lg flex items-center justify-center">
                        <i class="fas fa-chart-network text-blue-600 text-sm md:text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-white font-bold text-lg md:text-xl">EmpresaManager</h1>
                        <p class="text-blue-200 text-xs hidden md:block">Sistema de Gestão</p>
                    </div>
                </div>
                <button onclick="closeSidebar()" class="lg:hidden text-white p-2">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <!-- Menu de Navegação -->
            <nav class="p-3 md:p-4 space-y-1 mt-2 md:mt-4">
                <a href="<?php echo e(route('dashboard')); ?>"
                   onclick="closeSidebarMobile()"
                   class="nav-item flex items-center px-3 md:px-4 py-2 md:py-3 text-blue-100 <?php echo e(Route::currentRouteName() == 'dashboard' ? 'active' : ''); ?>">
                    <i class="fas fa-tachometer-alt w-5 md:w-6 text-center mr-2 md:mr-3 text-sm md:text-base"></i>
                    <span class="text-sm md:text-base">Dashboard</span>
                </a>

                <a href="<?php echo e(route('livewire.grupos')); ?>"
                   onclick="closeSidebarMobile()"
                   class="nav-item flex items-center px-3 md:px-4 py-2 md:py-3 text-blue-100 <?php echo e(Route::currentRouteName() == 'livewire.grupos' ? 'active' : ''); ?>">
                    <i class="fas fa-building w-5 md:w-6 text-center mr-2 md:mr-3 text-sm md:text-base"></i>
                    <span class="text-sm md:text-base">Grupos Econômicos</span>
                </a>

                <a href="<?php echo e(route('livewire.bandeiras')); ?>"
                   onclick="closeSidebarMobile()"
                   class="nav-item flex items-center px-3 md:px-4 py-2 md:py-3 text-blue-100 <?php echo e(Route::currentRouteName() == 'livewire.bandeiras' ? 'active' : ''); ?>">
                    <i class="fas fa-flag w-5 md:w-6 text-center mr-2 md:mr-3 text-sm md:text-base"></i>
                    <span class="text-sm md:text-base">Bandeiras</span>
                </a>

                <a href="<?php echo e(route('livewire.unidades')); ?>"
                   onclick="closeSidebarMobile()"
                   class="nav-item flex items-center px-3 md:px-4 py-2 md:py-3 text-blue-100 <?php echo e(Route::currentRouteName() == 'livewire.unidades' ? 'active' : ''); ?>">
                    <i class="fas fa-store w-5 md:w-6 text-center mr-2 md:mr-3 text-sm md:text-base"></i>
                    <span class="text-sm md:text-base">Unidades</span>
                </a>

                <a href="<?php echo e(route('livewire.colaboradores')); ?>"
                   onclick="closeSidebarMobile()"
                   class="nav-item flex items-center px-3 md:px-4 py-2 md:py-3 text-blue-100 <?php echo e(Route::currentRouteName() == 'livewire.colaboradores' ? 'active' : ''); ?>">
                    <i class="fas fa-users w-5 md:w-6 text-center mr-2 md:mr-3 text-sm md:text-base"></i>
                    <span class="text-sm md:text-base">Colaboradores</span>
                </a>

                <a href="<?php echo e(route('relatorio.colaboradores')); ?>"
                   onclick="closeSidebarMobile()"
                   class="nav-item flex items-center px-3 md:px-4 py-2 md:py-3 text-blue-100 <?php echo e(Route::currentRouteName() == 'relatorio.colaboradores' ? 'active' : ''); ?>">
                    <i class="fas fa-chart-bar w-5 md:w-6 text-center mr-2 md:mr-3 text-sm md:text-base"></i>
                    <span class="text-sm md:text-base">Relatórios</span>
                </a>

                <a href="<?php echo e(route('auditorias')); ?>"
                   onclick="closeSidebarMobile()"
                   class="nav-item flex items-center px-3 md:px-4 py-2 md:py-3 text-blue-100 <?php echo e(Route::currentRouteName() == 'auditorias' ? 'active' : ''); ?>">
                    <i class="fas fa-clipboard-list w-5 md:w-6 text-center mr-2 md:mr-3 text-sm md:text-base"></i>
                    <span class="text-sm md:text-base">Auditoria</span>
                </a>
            </nav>

            <!-- Usuário Logado -->
            <div class="absolute bottom-0 left-0 right-0 p-3 md:p-4 border-t border-blue-700">
                <div class="flex items-center space-x-2 md:space-x-3">
                    <div class="w-6 h-6 md:w-8 md:h-8 bg-blue-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-white text-xs md:text-sm"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-white text-xs md:text-sm font-medium truncate">
                            <?php echo e(Auth::user()->name ?? 'Usuário'); ?>

                        </p>
                        <p class="text-blue-200 text-xs truncate hidden md:block">Administrador</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Conteúdo Principal -->
        <div class="flex-1 lg:ml-64 w-full">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-4 md:px-6 lg:px-8 py-3 md:py-4">
                    <!-- Botão Menu Mobile e Breadcrumb -->
                    <div class="flex items-center space-x-2 md:space-x-4">
                        <button onclick="openSidebar()"
                                class="lg:hidden p-2 text-gray-600 hover:text-blue-600 transition">
                            <i class="fas fa-bars text-lg"></i>
                        </button>
                        <div class="flex items-center space-x-1 md:space-x-2 text-xs md:text-sm text-gray-600">
                            <span class="hidden sm:inline">Dashboard</span>
                            <i class="fas fa-chevron-right text-xs hidden sm:inline"></i>
                            <span class="text-gray-900 font-medium truncate max-w-[120px] sm:max-w-none"><?php echo e($title ?? 'Página Inicial'); ?></span>
                        </div>
                    </div>

                    <!-- Ações do Usuário -->
                    <div class="flex items-center space-x-2 md:space-x-4">
                        <!-- Notificações -->
                        <button class="relative p-2 text-gray-600 hover:text-blue-600 transition">
                            <i class="fas fa-bell text-sm md:text-base"></i>
                            <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>

                        <!-- Perfil - Alpine APENAS AQUI -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                    class="flex items-center space-x-1 md:space-x-2 p-1 md:p-2 rounded-lg hover:bg-gray-100 transition">
                                <div class="w-6 h-6 md:w-8 md:h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-white text-xs md:text-sm"></i>
                                </div>
                                <span class="text-xs md:text-sm font-medium text-gray-700 hidden sm:block">
                                    <?php echo e(Auth::user()->name ?? 'Usuário'); ?>

                                </span>
                                <i class="fas fa-chevron-down text-xs text-gray-500 hidden sm:block"></i>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open" @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform scale-95"
                                 x-transition:enter-end="opacity-100 transform scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="opacity-100 transform scale-100"
                                 x-transition:leave-end="opacity-0 transform scale-95"
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50">
                                <a href="<?php echo e(route('profile.edit')); ?>"
                                   class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-user-edit mr-3 text-gray-400"></i>
                                    Meu Perfil
                                </a>
                                <a href="#"
                                   class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-cog mr-3 text-gray-400"></i>
                                    Configurações
                                </a>
                                <div class="border-t border-gray-100 my-1"></div>
                                <form method="POST" action="<?php echo e(route('logout')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit"
                                            class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-gray-50">
                                        <i class="fas fa-sign-out-alt mr-3"></i>
                                        Sair do Sistema
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Conteúdo -->
            <main class="p-4 md:p-6 lg:p-8">
                <!-- Alertas -->
                <?php if(session('success')): ?>
                    <div class="mb-4 md:mb-6 bg-green-50 border border-green-200 rounded-xl p-3 md:p-4 flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-2 md:mr-3 text-sm md:text-base"></i>
                        <span class="text-green-700 text-sm md:text-base"><?php echo e(session('success')); ?></span>
                    </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                    <div class="mb-4 md:mb-6 bg-red-50 border border-red-200 rounded-xl p-3 md:p-4 flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 mr-2 md:mr-3 text-sm md:text-base"></i>
                        <span class="text-red-700 text-sm md:text-base"><?php echo e(session('error')); ?></span>
                    </div>
                <?php endif; ?>

                <?php if(session('message')): ?>
                    <div class="mb-4 md:mb-6 bg-blue-50 border border-blue-200 rounded-xl p-3 md:p-4 flex items-center">
                        <i class="fas fa-info-circle text-blue-500 mr-2 md:mr-3 text-sm md:text-base"></i>
                        <span class="text-blue-700 text-sm md:text-base"><?php echo e(session('message')); ?></span>
                    </div>
                <?php endif; ?>

                <!-- Conteúdo Dinâmico -->
                <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <?php echo e($slot); ?>

                </div>
            </main>
        </div>
    </div>

    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

    <?php echo app('Illuminate\Foundation\Vite')('resources/js/app.js'); ?>

    <script>
        function openSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobileOverlay');

            if (sidebar && overlay) {
                sidebar.classList.add('open');
                overlay.classList.remove('hidden');

                // Prevenir scroll do body quando sidebar está aberto
                document.body.style.overflow = 'hidden';
            }
        }

        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobileOverlay');

            if (sidebar && overlay) {
                sidebar.classList.remove('open');
                overlay.classList.add('hidden');

                // Restaurar scroll do body
                document.body.style.overflow = '';
            }
        }

        function closeSidebarMobile() {
            if (window.innerWidth < 1024) {
                closeSidebar();
            }
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeSidebar();
            }
        });

        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                closeSidebar();
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            if (window.innerWidth >= 1024) {
                const sidebar = document.getElementById('sidebar');
                if (sidebar) {
                    sidebar.classList.remove('sidebar-mobile');
                }
            }
        });
    </script>
</body>
</html>
<?php /**PATH /home/igor/gestao-grupos/resources/views/components/layouts/app.blade.php ENDPATH**/ ?>