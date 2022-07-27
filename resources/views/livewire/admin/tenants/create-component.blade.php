<div class="flex-1 h-screen p-5">
    <div class="flex flex-col">
        <div class="recent-activity block">
            <div class="w-full py-2">
                <x-slot name="header">
                    <!-- Section Hero -->
                    @include('tenant::header', ['label'=>"Cadastrar","url"=>route(config('tenant.routes.tenant.list'))])
                </x-slot>
            </div>
            <div   class="flex flex-col">
                <div class="mt-5 md:mt-0">
                    <form wire:submit.prevent="saveAndStay">
                        <div class="shadow sm:rounded-md ">                            
                        @include('tenant::livewire.admin.tenants.form')
                        </div>
                        <div class="flex justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 z-10 space-x-2">
                            <x-button wire:loading.attr="disabled" squared negative
                                href="{{ route(config('tenant.routes.tenant.list')) }}"
                                label="{{ __('Voltar para alista') }}" icon="x" />
                            <x-button type="submit" wire:loading.attr="disabled" squared primary
                                label="{{ __('Sarvar as alterações') }}" icon="check" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>