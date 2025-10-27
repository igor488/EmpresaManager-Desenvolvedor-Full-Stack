<div>
    <div class="bg-white overflow-hidden shadow-sm rounded-2xl">
        <div class="p-4 md:p-6 text-gray-900">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
                <div>
                    <h2 class="text-xl md:text-2xl font-bold text-gray-800">Bandeiras</h2>
                    <p class="text-gray-600 text-sm mt-1">Gerencie as bandeiras do sistema</p>
                </div>

                <button wire:click="openModal"
                        type="button"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-xl font-semibold transition-all duration-200 flex items-center gap-2 w-full sm:w-auto justify-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <i class="fas fa-plus"></i>
                    Nova Bandeira
                </button>
            </div>

            <!-- Alertas -->
            <!--[if BLOCK]><![endif]--><?php if(session()->has('message')): ?>
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-4 flex items-center">
                    <i class="fas fa-check-circle mr-3 text-green-500"></i>
                    <?php echo e(session('message')); ?>

                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <?php if(session()->has('error')): ?>
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4 flex items-center">
                    <i class="fas fa-exclamation-circle mr-3 text-red-500"></i>
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <!-- Modal -->
            <!--[if BLOCK]><![endif]--><?php if($isModalOpen): ?>
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-auto">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">
                                <?php echo e($bandeira_id ? 'Editar Bandeira' : 'Nova Bandeira'); ?>

                            </h3>
                            <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600 transition">
                                <i class="fas fa-times text-lg"></i>
                            </button>
                        </div>

                        <form wire:submit.prevent="store" class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nome</label>
                                <input type="text"
                                       wire:model="nome"
                                       class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                       placeholder="Nome da bandeira"
                                       required>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['nome'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-red-500 text-sm mt-1 block"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Grupo Econômico</label>
                                <select wire:model="grupo_id"
                                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                        required>
                                    <option value="">Selecione um grupo</option>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $grupos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grupo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($grupo->id); ?>"><?php echo e($grupo->nome); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </select>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['grupo_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-red-500 text-sm mt-1 block"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>

                            <div class="flex justify-end gap-3 pt-4">
                                <button type="button"
                                        wire:click="closeModal"
                                        class="px-4 py-2.5 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition duration-200 font-medium flex items-center gap-2">
                                    <i class="fas fa-times"></i>
                                    Cancelar
                                </button>
                                <button type="submit"
                                        class="px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-xl transition duration-200 font-medium flex items-center gap-2 shadow-lg hover:shadow-xl">
                                    <i class="fas fa-save"></i>
                                    Salvar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <!-- Tabela - Desktop -->
            <div class="hidden md:block">
                <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    ID
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Nome
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Grupo
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $bandeiras; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bandeira): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        #<?php echo e($bandeira->id); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-flag text-blue-500"></i>
                                            <?php echo e($bandeira->nome); ?>

                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        <?php echo e($bandeira->grupoEconomico->nome ?? '-'); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center gap-3">
                                            <button wire:click="edit(<?php echo e($bandeira->id); ?>)"
                                                    type="button"
                                                    class="text-blue-600 hover:text-blue-800 transition duration-200 flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-50 hover:bg-blue-100">
                                                <i class="fas fa-edit text-xs"></i>
                                                Editar
                                            </button>
                                            <button wire:click="delete(<?php echo e($bandeira->id); ?>)"
                                                    type="button"
                                                    class="text-red-600 hover:text-red-800 transition duration-200 flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-red-50 hover:bg-red-100"
                                                    onclick="return confirm('Tem certeza que deseja excluir esta bandeira?')">
                                                <i class="fas fa-trash text-xs"></i>
                                                Excluir
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fas fa-flag text-4xl text-gray-300 mb-3"></i>
                                            <p class="text-lg font-medium text-gray-500">Nenhuma bandeira encontrada</p>
                                            <p class="text-sm text-gray-400 mt-1">Clique em "Nova Bandeira" para adicionar a primeira</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Cards - Mobile -->
            <div class="md:hidden space-y-3">
                <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $bandeiras; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bandeira): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm hover:shadow-md transition duration-200">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-flag text-blue-500 mt-1"></i>
                                <div>
                                    <h3 class="font-semibold text-gray-900"><?php echo e($bandeira->nome); ?></h3>
                                    <p class="text-sm text-gray-500">ID: #<?php echo e($bandeira->id); ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between items-center py-1 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-600">Grupo:</span>
                                <span class="text-sm text-gray-900"><?php echo e($bandeira->grupoEconomico->nome ?? '-'); ?></span>
                            </div>
                        </div>

                        <div class="flex justify-end gap-2 pt-3 border-t border-gray-100">
                            <button wire:click="edit(<?php echo e($bandeira->id); ?>)"
                                    class="flex items-center gap-2 px-3 py-2 text-blue-600 hover:text-blue-800 transition duration-200 text-sm font-medium">
                                <i class="fas fa-edit text-xs"></i>
                                Editar
                            </button>
                            <button wire:click="delete(<?php echo e($bandeira->id); ?>)"
                                    class="flex items-center gap-2 px-3 py-2 text-red-600 hover:text-red-800 transition duration-200 text-sm font-medium"
                                    onclick="return confirm('Tem certeza que deseja excluir esta bandeira?')">
                                <i class="fas fa-trash text-xs"></i>
                                Excluir
                            </button>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-12">
                        <i class="fas fa-flag text-5xl text-gray-300 mb-4"></i>
                        <p class="text-lg font-medium text-gray-500 mb-2">Nenhuma bandeira encontrada</p>
                        <p class="text-sm text-gray-400">Clique no botão acima para adicionar a primeira bandeira</p>
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>

            <!-- Paginação -->
            <!--[if BLOCK]><![endif]--><?php if($bandeiras->hasPages()): ?>
                <div class="mt-6 flex justify-center">
                    <div class="bg-white px-4 py-3 rounded-lg border border-gray-200 shadow-sm">
                        <?php echo e($bandeiras->links()); ?>

                    </div>
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>
</div>
<?php /**PATH /home/igor/gestao-grupos/resources/views/livewire/bandeiras.blade.php ENDPATH**/ ?>