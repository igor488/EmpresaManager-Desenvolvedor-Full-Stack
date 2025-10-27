
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <!-- Cabeçalho -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Relatório de Colaboradores</h2>
                    <p class="text-gray-600 mt-1">Exporte dados de colaboradores com filtros avançados</p>
                </div>

                <!-- Estatísticas -->
                <div class="text-right">
                    <div class="text-sm text-gray-600">
                        <span class="font-semibold"><?php echo e($estatisticas['total']); ?></span> colaborador(es) encontrado(s)
                        <!--[if BLOCK]><![endif]--><?php if($estatisticas['com_filtro']): ?>
                            <span class="text-blue-600 ml-2">(com filtro)</span>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
            </div>

            <!-- Filtros -->
            <div class="bg-gray-50 rounded-lg p-6 mb-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Filtros de Exportação</h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Grupo Econômico -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Grupo Econômico</label>
                        <select wire:model.live="grupo_id"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                            <option value="">Todos os grupos</option>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $grupos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grupo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($grupo->id); ?>"><?php echo e($grupo->nome); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </select>
                    </div>

                    <!-- Bandeira -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Bandeira</label>
                        <select wire:model.live="bandeira_id"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                                <?php echo e(empty($bandeirasFiltradas) ? 'disabled' : ''); ?>>
                            <option value="">Todas as bandeiras</option>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $bandeirasFiltradas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bandeira): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($bandeira->id); ?>"><?php echo e($bandeira->nome); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </select>
                        <!--[if BLOCK]><![endif]--><?php if(empty($bandeirasFiltradas)): ?>
                            <p class="text-xs text-gray-500 mt-1">Selecione um grupo primeiro</p>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <!-- Unidade -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Unidade</label>
                        <select wire:model.live="unidade_id"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                                <?php echo e(empty($unidadesFiltradas) ? 'disabled' : ''); ?>>
                            <option value="">Todas as unidades</option>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $unidadesFiltradas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unidade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($unidade->id); ?>"><?php echo e($unidade->nome_fantasia); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </select>
                        <!--[if BLOCK]><![endif]--><?php if(empty($unidadesFiltradas)): ?>
                            <p class="text-xs text-gray-500 mt-1">Selecione uma bandeira primeiro</p>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>

                <!-- Status da Exportação -->
                <!--[if BLOCK]><![endif]--><?php if($this->currentExport): ?>
                    <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-3 h-3 rounded-full
                                    <?php if($this->currentExport->status === 'processing'): ?> bg-yellow-500 animate-pulse
                                    <?php elseif($this->currentExport->status === 'completed'): ?> bg-green-500
                                    <?php elseif($this->currentExport->status === 'failed'): ?> bg-red-500
                                    <?php else: ?> bg-blue-500 <?php endif; ?> mr-3">
                                </div>
                                <div>
                                    <h4 class="font-semibold text-blue-800 text-sm">Status da Exportação</h4>
                                    <p class="text-blue-700 text-sm">
                                        <!--[if BLOCK]><![endif]--><?php if($this->currentExport->status === 'queued'): ?>
                                            ⏳ Na fila de processamento...
                                        <?php elseif($this->currentExport->status === 'processing'): ?>
                                            🔄 Processando... <?php echo e($this->currentExport->progress); ?>%
                                        <?php elseif($this->currentExport->status === 'completed'): ?>
                                            ✅ <strong>Concluído!</strong>
                                        <?php else: ?>
                                            ❌ Falha na exportação
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </p>
                                </div>
                            </div>

                          <!--[if BLOCK]><![endif]--><?php if($this->currentExport->status === 'completed'): ?>
    <!-- ✅ BOTÃO CORRIGIDO - Usando a propriedade computada -->
    <!--[if BLOCK]><![endif]--><?php if($this->downloadUrl): ?>
        <a href="<?php echo e($this->downloadUrl); ?>"
           download="<?php echo e($this->currentExport->file_name); ?>"
           target="_blank"
           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Baixar Excel
        </a>
    <?php else: ?>
        <button wire:click="downloadExport"
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Baixar Excel
        </button>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        <!-- Informações simples -->
                        <!--[if BLOCK]><![endif]--><?php if($this->currentExport->status === 'completed'): ?>
                            <div class="mt-3 text-xs text-green-700 bg-green-100 p-2 rounded">
                                ✅ Arquivo gerado: <strong><?php echo e($this->currentExport->filename); ?></strong>
                                - Pronto para download

                                <!-- Debug info -->
                                <!--[if BLOCK]><![endif]--><?php if($this->downloadUrl): ?>
                                    <div class="mt-1 text-blue-600">
                                        🔗 URL: <?php echo e($this->downloadUrl); ?>

                                    </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        <!--[if BLOCK]><![endif]--><?php if($this->currentExport->status === 'failed'): ?>
                            <div class="mt-2 p-2 bg-red-50 rounded text-sm text-red-700">
                                <strong>Erro:</strong> <?php echo e($this->currentExport->error_message); ?>

                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <!-- Botão Exportar -->
                <div class="mt-6 flex justify-between items-center">
                    <div>
                        <!--[if BLOCK]><![endif]--><?php if($polling): ?>
                            <p class="text-sm text-gray-600">
                                ⏰ Atualizando automaticamente...
                            </p>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <div class="flex gap-3">
                        <!-- Botão Limpar -->
                        <button wire:click="$set('grupo_id', '')"
                                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-3 rounded-lg font-medium transition flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Limpar Filtros
                        </button>

                        <!-- Botão Exportar -->
                        <button wire:click="exportExcel"
                                wire:loading.attr="disabled"
                                wire:target="exportExcel"
                                class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">

                            <!--[if BLOCK]><![endif]--><?php if($exportando): ?>
                                <svg class="animate-spin w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                <span>Processando...</span>
                            <?php else: ?>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span>Exportar para Excel</span>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </button>
                    </div>
                </div>
            </div>

            <!-- Polling automático (hidden) -->
            <!--[if BLOCK]><![endif]--><?php if($polling): ?>
                <div wire:poll.5000ms="checkExportStatus" class="hidden"></div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <!-- Informações -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h4 class="font-semibold text-blue-800">Informações do Relatório</h4>
                        <p class="text-blue-700 text-sm mt-1">
                            O relatório será exportado em formato Excel contendo todas as informações dos colaboradores
                            com os filtros aplicados. O arquivo incluirá dados completos como nome, email, CPF,
                            unidade, bandeira e grupo econômico.
                        </p>
                        <p class="text-blue-600 text-xs mt-2 font-medium">
                            💡 <strong>Novo:</strong> Agora as exportações são processadas em background para melhor performance!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php /**PATH /home/igor/gestao-grupos/resources/views/livewire/relatorio-colaboradores.blade.php ENDPATH**/ ?>