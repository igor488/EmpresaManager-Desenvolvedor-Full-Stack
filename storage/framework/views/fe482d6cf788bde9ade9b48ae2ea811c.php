<?php
use Illuminate\Support\Facades\Auth;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestão</title>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-blue-800 text-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <h1 class="text-xl font-bold">Gestão de Grupos</h1>
                        </div>
                        <div class="hidden md:ml-6 md:flex md:space-x-4">
                            <a href="<?php echo e(route('dashboard')); ?>"
                               class="<?php echo e(request()->routeIs('dashboard') ? 'bg-blue-900' : ''); ?> px-3 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition">
                                Dashboard
                            </a>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <?php if(auth()->guard()->check()): ?>
                            <span class="mr-4"><?php echo e(Auth::user()->name); ?></span>
                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-sm transition">
                                    Sair
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main>
            <?php echo e($slot); ?>

        </main>
    </div>

    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

</body>
</html>
<?php /**PATH /home/igor/gestao-grupos/resources/views/layouts/app.blade.php ENDPATH**/ ?>