<div class="flex-1 h-screen p-5">
    <div class="flex flex-col">
        <div class="recent-activity block">
            <div class="w-full py-2">
                <x-slot name="header">
                    <!-- Section Hero -->
                    @include('tenant::header', ['label' => 'Tenants'])
                </x-slot>
            </div>
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto">
                    <div class="py-2 min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg min-h-[400px]">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" wire:click="sortBy('name')"
                                            class=" px-6 cursor-pointer py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <div class="flex space-x-2">
                                                {{ __('Name') }}
                                            </div>
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Domain') }}
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Created At') }}
                                        </th>
                                        <th colspan="2" scope="col"
                                            class="px-6 py-3 flex space-x-2 w-full items-center">
                                            <div class="flex-1">
                                                <x-input icon="search" wire:model="filters.search"
                                                    placeholder="{{ __('Search...') }}" />
                                            </div>
                                            <x-button icon="plus" positive  squared
                                                href="{{ route(config('tenant.routes.tenant.create')) }}"
                                                label="{{ __('Adicionar') }}" teal flat/>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody wire:sortable="updateOrder" class="bg-white divide-y divide-gray-200">
                                    @foreach ($models as $model)
                                        <tr wire:sortable.item="{{ $model->id }}">
                                            <td class="flex items-center px-6 py-4 space-x-2">
                                                <div wire:sortable.handle class="flex align-middle cursor-move">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                        stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <span>{{ $model->name }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-wrap">
                                                {{ $model->domain }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-wrap">
                                                {{ $model->created_at }}
                                            </td>
                                            <td>
                                                <div class="flex px-2 space-x-2 align-middle">
                                                    <x-button icon="pencil" sm primary squared
                                                        href="{{ route(config('tenant.routes.tenant.edit'), $model) }}"
                                                        label="{{ __('Editar') }}" teal />
                                                    <x-button
                                                    x-on:confirm="{
                                                        title:'{{ __('ATENÇÃO!') }}',
                                                        description:'{{ sprintf('Deseja realmente excluir o registro - %s', $model->name)}}',
                                                        icon: 'error',
                                                        method: 'kill',
                                                        params: '{{ data_get($model, 'id') }}'
                                                    }"
                                                     icon="x" negative sm squared
                                                        label="{{ __('Deletar') }}" teal />
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="py-2 px-3" colspan="4">
                                            <div class="h-4 w-full">
                                                {{ $models->links() }}
                                            </div>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
