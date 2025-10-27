<x-app-layout>
    <div class="py-4 md:py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Welcome Card -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl shadow-lg text-white p-4 md:p-6 mb-6 md:mb-8">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-3 md:gap-4">
                    <div class="flex-1">
                        <h1 class="text-xl md:text-2xl lg:text-3xl font-bold mb-2">Bem-vindo, {{ auth()->user()->name }}! 👋</h1>
                        <p class="text-blue-100 text-sm md:text-base lg:text-lg">Aqui está o resumo do seu grupo econômico</p>
                    </div>
                    <div class="text-left md:text-right mt-2 md:mt-0">
                        <p class="text-blue-100 text-xs md:text-sm lg:text-base">{{ now()->format('d/m/Y - H:i') }}</p>
                        <p class="text-xs text-blue-200">Última atualização</p>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 lg:gap-6 mb-6 md:mb-8">
                <div class="bg-white rounded-xl shadow-sm p-3 md:p-4 lg:p-6 border-l-4 border-blue-500">
                    <div class="flex items-center">
                        <div class="p-2 md:p-3 rounded-full bg-blue-100 text-blue-600 mr-2 md:mr-3 lg:mr-4">
                            <i class="fas fa-building text-base md:text-lg lg:text-xl"></i>
                        </div>
                        <div>
                            <p class="text-xs md:text-sm font-medium text-gray-600">Grupos</p>
                            <p class="text-lg md:text-xl lg:text-2xl font-bold text-gray-900">{{ $totalGrupos }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-3 md:p-4 lg:p-6 border-l-4 border-green-500">
                    <div class="flex items-center">
                        <div class="p-2 md:p-3 rounded-full bg-green-100 text-green-600 mr-2 md:mr-3 lg:mr-4">
                            <i class="fas fa-flag text-base md:text-lg lg:text-xl"></i>
                        </div>
                        <div>
                            <p class="text-xs md:text-sm font-medium text-gray-600">Bandeiras</p>
                            <p class="text-lg md:text-xl lg:text-2xl font-bold text-gray-900">{{ $totalBandeiras }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-3 md:p-4 lg:p-6 border-l-4 border-yellow-500">
                    <div class="flex items-center">
                        <div class="p-2 md:p-3 rounded-full bg-yellow-100 text-yellow-600 mr-2 md:mr-3 lg:mr-4">
                            <i class="fas fa-store text-base md:text-lg lg:text-xl"></i>
                        </div>
                        <div>
                            <p class="text-xs md:text-sm font-medium text-gray-600">Unidades</p>
                            <p class="text-lg md:text-xl lg:text-2xl font-bold text-gray-900">{{ $totalUnidades }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-3 md:p-4 lg:p-6 border-l-4 border-red-500">
                    <div class="flex items-center">
                        <div class="p-2 md:p-3 rounded-full bg-red-100 text-red-600 mr-2 md:mr-3 lg:mr-4">
                            <i class="fas fa-users text-base md:text-lg lg:text-xl"></i>
                        </div>
                        <div>
                            <p class="text-xs md:text-sm font-medium text-gray-600">Colaboradores</p>
                            <p class="text-lg md:text-xl lg:text-2xl font-bold text-gray-900">{{ $totalColaboradores }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions & Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-6 lg:gap-8">
                <!-- Quick Actions -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6">
                        <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-4 md:mb-6">Ações Rápidas</h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 md:gap-4">
                            <a href="{{ route('livewire.colaboradores') }}"
                               class="flex items-center p-3 md:p-4 border border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition group">
                                <div class="p-2 md:p-3 rounded-full bg-blue-100 text-blue-600 mr-2 md:mr-3 lg:mr-4 group-hover:bg-blue-200 transition">
                                    <i class="fas fa-user-plus text-sm md:text-base"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="font-semibold text-gray-900 text-sm md:text-base truncate">Novo Colaborador</p>
                                    <p class="text-xs md:text-sm text-gray-600 truncate">Adicionar à unidade</p>
                                </div>
                            </a>

                            <a href="{{ route('relatorio.colaboradores') }}"
                               class="flex items-center p-3 md:p-4 border border-gray-200 rounded-lg hover:border-green-500 hover:bg-green-50 transition group">
                                <div class="p-2 md:p-3 rounded-full bg-green-100 text-green-600 mr-2 md:mr-3 lg:mr-4 group-hover:bg-green-200 transition">
                                    <i class="fas fa-file-export text-sm md:text-base"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="font-semibold text-gray-900 text-sm md:text-base truncate">Exportar Relatório</p>
                                    <p class="text-xs md:text-sm text-gray-600 truncate">Dados em Excel</p>
                                </div>
                            </a>

                            <a href="{{ route('auditorias') }}"
                               class="flex items-center p-3 md:p-4 border border-gray-200 rounded-lg hover:border-purple-500 hover:bg-purple-50 transition group">
                                <div class="p-2 md:p-3 rounded-full bg-purple-100 text-purple-600 mr-2 md:mr-3 lg:mr-4 group-hover:bg-purple-200 transition">
                                    <i class="fas fa-history text-sm md:text-base"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="font-semibold text-gray-900 text-sm md:text-base truncate">Ver Auditoria</p>
                                    <p class="text-xs md:text-sm text-gray-600 truncate">Histórico de alterações</p>
                                </div>
                            </a>

                            <a href="{{ route('livewire.grupos') }}"
                               class="flex items-center p-3 md:p-4 border border-gray-200 rounded-lg hover:border-orange-500 hover:bg-orange-50 transition group">
                                <div class="p-2 md:p-3 rounded-full bg-orange-100 text-orange-600 mr-2 md:mr-3 lg:mr-4 group-hover:bg-orange-200 transition">
                                    <i class="fas fa-sitemap text-sm md:text-base"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="font-semibold text-gray-900 text-sm md:text-base truncate">Gerenciar Grupos</p>
                                    <p class="text-xs md:text-sm text-gray-600 truncate">Estrutura organizacional</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white rounded-xl shadow-sm p-4 md:p-6">
                    <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-4 md:mb-6">Atividade Recente</h3>

                    <div class="space-y-3 md:space-y-4">
                        @forelse($atividadesRecentes as $atividade)
                        <div class="flex items-start space-x-2 md:space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-6 h-6 md:w-7 md:h-7 rounded-full flex items-center justify-center text-xs
                                    @if($atividade->acao == 'criado') bg-green-100 text-green-600
                                    @elseif($atividade->acao == 'atualizado') bg-yellow-100 text-yellow-600
                                    @else bg-red-100 text-red-600 @endif">
                                    <i class="fas
                                        @if($atividade->acao == 'criado') fa-plus
                                        @elseif($atividade->acao == 'atualizado') fa-edit
                                        @else fa-trash @endif text-xs">
                                    </i>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    {{ $atividade->entidade }} {{ $atividade->acao }}
                                </p>
                                <p class="text-xs text-gray-500 truncate">
                                    Por: {{ $atividade->user->name ?? 'Sistema' }} •
                                    {{ $atividade->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                        @empty
                        <div class="text-center text-gray-500 py-3 md:py-4">
                            <i class="fas fa-inbox text-xl md:text-2xl lg:text-3xl mb-2"></i>
                            <p class="text-sm">Nenhuma atividade recente</p>
                        </div>
                        @endforelse
                    </div>

                    @if($atividadesRecentes->count() > 0)
                    <a href="{{ route('auditorias') }}"
                       class="block mt-4 text-center text-sm text-blue-600 hover:text-blue-800 font-medium">
                        Ver todas as atividades →
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
