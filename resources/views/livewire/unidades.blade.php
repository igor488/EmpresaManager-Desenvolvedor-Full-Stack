<div>
    <div class="bg-white overflow-hidden shadow-sm rounded-2xl">
        <div class="p-4 md:p-6 text-gray-900">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
                <div>
                    <h2 class="text-xl md:text-2xl font-bold text-gray-800">Unidades</h2>
                    <p class="text-gray-600 text-sm mt-1">Gerencie as unidades do sistema</p>
                </div>

                <button wire:click="openModal"
                        type="button"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-xl font-semibold transition-all duration-200 flex items-center gap-2 w-full sm:w-auto justify-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <i class="fas fa-plus"></i>
                    Nova Unidade
                </button>
            </div>

            <!-- Alertas -->
            @if (session()->has('message'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-4 flex items-center">
                    <i class="fas fa-check-circle mr-3 text-green-500"></i>
                    {{ session('message') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4 flex items-center">
                    <i class="fas fa-exclamation-circle mr-3 text-red-500"></i>
                    {{ session('error') }}
                </div>
            @endif

            <!-- Modal -->
            @if($isModalOpen)
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-auto max-h-[90vh] overflow-y-auto">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">
                                {{ $unidade_id ? 'Editar Unidade' : 'Nova Unidade' }}
                            </h3>
                            <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600 transition">
                                <i class="fas fa-times text-lg"></i>
                            </button>
                        </div>

                        <form wire:submit.prevent="store" class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nome Fantasia</label>
                                <input type="text"
                                       wire:model="nome_fantasia"
                                       class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                       placeholder="Nome fantasia"
                                       required>
                                @error('nome_fantasia')
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Razão Social</label>
                                <input type="text"
                                       wire:model="razao_social"
                                       class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                       placeholder="Razão social"
                                       required>
                                @error('razao_social')
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">CNPJ</label>
                                <input type="text"
                                       wire:model.live="cnpj"
                                       x-data="{
                                           formatarCNPJ() {
                                               let cnpj = this.$el.value.replace(/\D/g, '');
                                               if (cnpj.length <= 14) {
                                                   if (cnpj.length <= 2) {
                                                       this.$el.value = cnpj;
                                                   } else if (cnpj.length <= 5) {
                                                       this.$el.value = cnpj.substring(0, 2) + '.' + cnpj.substring(2, 5);
                                                   } else if (cnpj.length <= 8) {
                                                       this.$el.value = cnpj.substring(0, 2) + '.' + cnpj.substring(2, 5) + '.' + cnpj.substring(5, 8);
                                                   } else if (cnpj.length <= 12) {
                                                       this.$el.value = cnpj.substring(0, 2) + '.' + cnpj.substring(2, 5) + '.' + cnpj.substring(5, 8) + '/' + cnpj.substring(8, 12);
                                                   } else {
                                                       this.$el.value = cnpj.substring(0, 2) + '.' + cnpj.substring(2, 5) + '.' + cnpj.substring(5, 8) + '/' + cnpj.substring(8, 12) + '-' + cnpj.substring(12, 14);
                                                   }
                                               }
                                           }
                                       }"
                                       x-on:input="formatarCNPJ()"
                                       class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                       placeholder="00.000.000/0000-00"
                                       maxlength="18"
                                       required>
                                @error('cnpj')
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Bandeira</label>
                                <select wire:model="bandeira_id"
                                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                        required>
                                    <option value="">Selecione uma bandeira</option>
                                    @foreach($bandeiras as $bandeira)
                                        <option value="{{ $bandeira->id }}">{{ $bandeira->nome }}</option>
                                    @endforeach
                                </select>
                                @error('bandeira_id')
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                @enderror
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
            @endif

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
                                    Nome Fantasia
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Razão Social
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    CNPJ
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Bandeira
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($unidades as $unidade)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        #{{ $unidade->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-store text-blue-500"></i>
                                            {{ $unidade->nome_fantasia }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $unidade->razao_social }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $this->formatarCnpj($unidade->cnpj) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-flag text-green-500 text-xs"></i>
                                            {{ $unidade->bandeira->nome ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center gap-3">
                                            <button wire:click="edit({{ $unidade->id }})"
                                                    type="button"
                                                    class="text-blue-600 hover:text-blue-800 transition duration-200 flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-50 hover:bg-blue-100">
                                                <i class="fas fa-edit text-xs"></i>
                                                Editar
                                            </button>
                                            <button wire:click="delete({{ $unidade->id }})"
                                                    type="button"
                                                    class="text-red-600 hover:text-red-800 transition duration-200 flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-red-50 hover:bg-red-100"
                                                    onclick="return confirm('Tem certeza que deseja excluir esta unidade?')">
                                                <i class="fas fa-trash text-xs"></i>
                                                Excluir
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fas fa-store text-4xl text-gray-300 mb-3"></i>
                                            <p class="text-lg font-medium text-gray-500">Nenhuma unidade encontrada</p>
                                            <p class="text-sm text-gray-400 mt-1">Clique em "Nova Unidade" para adicionar a primeira</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Cards - Mobile -->
            <div class="md:hidden space-y-3">
                @forelse($unidades as $unidade)
                    <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm hover:shadow-md transition duration-200">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-store text-blue-500 mt-1"></i>
                                <div>
                                    <h3 class="font-semibold text-gray-900">{{ $unidade->nome_fantasia }}</h3>
                                    <p class="text-sm text-gray-500">ID: #{{ $unidade->id }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between items-center py-1 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-600">Razão Social:</span>
                                <span class="text-sm text-gray-900 text-right">{{ $unidade->razao_social }}</span>
                            </div>
                            <div class="flex justify-between items-center py-1 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-600">CNPJ:</span>
                                <span class="text-sm text-gray-900">{{ $this->formatarCnpj($unidade->cnpj) }}</span>
                            </div>
                            <div class="flex justify-between items-center py-1 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-600">Bandeira:</span>
                                <span class="text-sm text-gray-900">{{ $unidade->bandeira->nome ?? '-' }}</span>
                            </div>
                        </div>

                        <div class="flex justify-end gap-2 pt-3 border-t border-gray-100">
                            <button wire:click="edit({{ $unidade->id }})"
                                    class="flex items-center gap-2 px-3 py-2 text-blue-600 hover:text-blue-800 transition duration-200 text-sm font-medium bg-blue-50 hover:bg-blue-100 rounded-lg">
                                <i class="fas fa-edit text-xs"></i>
                                Editar
                            </button>
                            <button wire:click="delete({{ $unidade->id }})"
                                    class="flex items-center gap-2 px-3 py-2 text-red-600 hover:text-red-800 transition duration-200 text-sm font-medium bg-red-50 hover:bg-red-100 rounded-lg"
                                    onclick="return confirm('Tem certeza que deseja excluir esta unidade?')">
                                <i class="fas fa-trash text-xs"></i>
                                Excluir
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <i class="fas fa-store text-5xl text-gray-300 mb-4"></i>
                        <p class="text-lg font-medium text-gray-500 mb-2">Nenhuma unidade encontrada</p>
                        <p class="text-sm text-gray-400">Clique no botão acima para adicionar a primeira unidade</p>
                    </div>
                @endforelse
            </div>

            <!-- Paginação -->
            @if($unidades->hasPages())
                <div class="mt-6 flex justify-center">
                    <div class="bg-white px-4 py-3 rounded-lg border border-gray-200 shadow-sm">
                        {{ $unidades->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
