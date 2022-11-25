<div class="px-4 py-5 bg-white space-y-6">
    <div class="md:grid md:grid-cols-12 gap-y-3 gap-x-4">
        <div class="col-span-5 ">
            <x-input wire:model="data.name" label="{{ __('Nome') }}" placeholder="{{ __('Nome') }}" />
        </div>      
        <div class="col-span-3">
            <x-input wire:model="data.domain" label="{{ __('Domain') }}" placeholder="{{ __('tenant.com.br') }}" />
        </div>              
        <div class="col-span-2">
            <x-input wire:model="data.provider" label="{{ __('Provider') }}" placeholder="{{ __('Provider') }}" />
        </div>                
        <div class="col-span-2">
            <x-input wire:model="data.database" label="{{ __('Database') }}" placeholder="{{ __('Database') }}" />
        </div>         
        <div class="col-span-12 flex items-center">
            <div class="my-2 flex space-x-3 h-full w-full items-center">
                <div>
                    <x-radio lg id="left-label" left-label="{{ __('PUBLICADO') }}" value="published"
                        wire:model.defer="data.status_id" />
                </div>
                <div>
                    <x-radio lg id="right-label" label="{{ __('RASCUNHO') }}" value="draft"
                        wire:model.defer="data.status_id" />
                </div>
            </div>
        </div>
    </div>
</div>
