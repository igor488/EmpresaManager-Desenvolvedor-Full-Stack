<div>
    <div class="bg-white overflow-hidden shadow-sm rounded-2xl">
        <div class="p-4 md:p-6 text-gray-900">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
                <div>
                    <h2 class="text-xl md:text-2xl font-bold text-gray-800">Colaboradores</h2>
                    <p class="text-gray-600 text-sm mt-1">Gerencie os colaboradores do sistema</p>
                </div>

                <button wire:click="openModal"
                        type="button"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-xl font-semibold transition-all duration-200 flex items-center gap-2 w-full sm:w-auto justify-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <i class="fas fa-user-plus"></i>
                    Novo Colaborador
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
                <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50"
                     x-data="{ loading: false }"
                     x-init="$watch('loading', (value) => { if (value) setTimeout(() => loading = false, 2000) })">
                    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-auto max-h-[90vh] overflow-y-auto">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-900">
                                    <?php echo e($colaborador_id ? 'Editar Colaborador' : 'Novo Colaborador'); ?>

                                </h3>
                                <button wire:click="closeModal"
                                        :disabled="loading"
                                        class="text-gray-400 hover:text-gray-600 transition disabled:opacity-50">
                                    <i class="fas fa-times text-lg"></i>
                                </button>
                            </div>

                            <form wire:submit.prevent="store"
                                  @submit="loading = true">
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nome</label>
                                    <input type="text"
                                           wire:model="nome"
                                           :disabled="loading"
                                           class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 disabled:opacity-50"
                                           placeholder="Nome completo"
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

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                    <input type="email"
                                           wire:model="email"
                                           :disabled="loading"
                                           class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 disabled:opacity-50"
                                           placeholder="email@exemplo.com"
                                           required>
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['email'];
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

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">CPF</label>
                                    <input type="text"
                                           wire:model.live="cpf"
                                           :disabled="loading"
                                           x-data="{
                                               formatarCPF() {
                                                   let cpf = this.$el.value.replace(/\D/g, '');
                                                   if (cpf.length <= 11) {
                                                       if (cpf.length <= 3) {
                                                           this.$el.value = cpf;
                                                       } else if (cpf.length <= 6) {
                                                           this.$el.value = cpf.substring(0, 3) + '.' + cpf.substring(3, 6);
                                                       } else if (cpf.length <= 9) {
                                                           this.$el.value = cpf.substring(0, 3) + '.' + cpf.substring(3, 6) + '.' + cpf.substring(6, 9);
                                                       } else {
                                                           this.$el.value = cpf.substring(0, 3) + '.' + cpf.substring(3, 6) + '.' + cpf.substring(6, 9) + '-' + cpf.substring(9, 11);
                                                       }
                                                   }
                                               }
                                           }"
                                           x-on:input="formatarCPF()"
                                           class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 disabled:opacity-50"
                                           placeholder="123.456.789-00"
                                           maxlength="14"
                                           required>
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['cpf'];
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

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Unidade</label>
                                    <select wire:model="unidade_id"
                                            :disabled="loading"
                                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 disabled:opacity-50"
                                            required>
                                        <option value="">Selecione uma unidade</option>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $unidades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unidade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($unidade->id); ?>"><?php echo e($unidade->nome_fantasia); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </select>
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['unidade_id'];
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
                                            :disabled="loading"
                                            class="px-4 py-2.5 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition duration-200 font-medium flex items-center gap-2 disabled:opacity-50">
                                        <i class="fas fa-times"></i>
                                        Cancelar
                                    </button>
                                    <button type="submit"
                                            :disabled="loading"
                                            class="px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-xl transition duration-200 font-medium flex items-center gap-2 shadow-lg hover:shadow-xl disabled:opacity-50">
                                        <i class="fas fa-save" :class="{ 'fa-spinner animate-spin': loading }"></i>
                                        <span x-text="loading ? 'Salvando...' : 'Salvar'"></span>
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
                                    Email
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    CPF
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Unidade
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $colaboradores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $colaborador): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        #<?php echo e($colaborador->id); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-user text-blue-500"></i>
                                            <?php echo e($colaborador->nome); ?>

                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        <?php echo e($colaborador->email); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        <?php echo e($this->formatarCpf($colaborador->cpf)); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        <?php echo e($colaborador->unidade->nome_fantasia ?? '-'); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center gap-3">
                                            <button wire:click="edit(<?php echo e($colaborador->id); ?>)"
                                                    type="button"
                                                    class="text-blue-600 hover:text-blue-800 transition duration-200 flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-50 hover:bg-blue-100">
                                                <i class="fas fa-edit text-xs"></i>
                                                Editar
                                            </button>
                                            <button wire:click="delete(<?php echo e($colaborador->id); ?>)"
                                                    type="button"
                                                    class="text-red-600 hover:text-red-800 transition duration-200 flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-red-50 hover:bg-red-100"
                                                    onclick="return confirm('Tem certeza que deseja excluir este colaborador?')">
                                                <i class="fas fa-trash text-xs"></i>
                                                Excluir
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fas fa-users text-4xl text-gray-300 mb-3"></i>
                                            <p class="text-lg font-medium text-gray-500">Nenhum colaborador encontrado</p>
                                            <p class="text-sm text-gray-400 mt-1">Clique em "Novo Colaborador" para adicionar o primeiro</p>
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
                <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $colaboradores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $colaborador): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm hover:shadow-md transition duration-200">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-user text-blue-500 mt-1"></i>
                                <div>
                                    <h3 class="font-semibold text-gray-900"><?php echo e($colaborador->nome); ?></h3>
                                    <p class="text-sm text-gray-500">ID: #<?php echo e($colaborador->id); ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between items-center py-1 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-600">Email:</span>
                                <span class="text-sm text-gray-900 truncate max-w-[150px]"><?php echo e($colaborador->email); ?></span>
                            </div>
                            <div class="flex justify-between items-center py-1 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-600">CPF:</span>
                                <span class="text-sm text-gray-900"><?php echo e($this->formatarCpf($colaborador->cpf)); ?></span>
                            </div>
                            <div class="flex justify-between items-center py-1 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-600">Unidade:</span>
                                <span class="text-sm text-gray-900"><?php echo e($colaborador->unidade->nome_fantasia ?? '-'); ?></span>
                            </div>
                        </div>

                        <div class="flex justify-end gap-2 pt-3 border-t border-gray-100">
                            <button wire:click="edit(<?php echo e($colaborador->id); ?>)"
                                    class="flex items-center gap-2 px-3 py-2 text-blue-600 hover:text-blue-800 transition duration-200 text-sm font-medium bg-blue-50 hover:bg-blue-100 rounded-lg">
                                <i class="fas fa-edit text-xs"></i>
                                Editar
                            </button>
                            <button wire:click="delete(<?php echo e($colaborador->id); ?>)"
                                    class="flex items-center gap-2 px-3 py-2 text-red-600 hover:text-red-800 transition duration-200 text-sm font-medium bg-red-50 hover:bg-red-100 rounded-lg"
                                    onclick="return confirm('Tem certeza que deseja excluir este colaborador?')">
                                <i class="fas fa-trash text-xs"></i>
                                Excluir
                            </button>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-12">
                        <i class="fas fa-users text-5xl text-gray-300 mb-4"></i>
                        <p class="text-lg font-medium text-gray-500 mb-2">Nenhum colaborador encontrado</p>
                        <p class="text-sm text-gray-400">Clique no botão acima para adicionar o primeiro colaborador</p>
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>

            <!-- Paginação -->
            <!--[if BLOCK]><![endif]--><?php if($colaboradores->hasPages()): ?>
                <div class="mt-6 flex justify-center">
                    <div class="bg-white px-4 py-3 rounded-lg border border-gray-200 shadow-sm">
                        <?php echo e($colaboradores->links()); ?>

                    </div>
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>
</div>
<?php /**PATH /home/igor/gestao-grupos/resources/views/livewire/colaboradores.blade.php ENDPATH**/ ?>