<x-tall-app-form-main :formAttr="$formAttr">
    <x-tall-app-form :formAttr="$formAttr" loading="search">
        <x-slot name="messages">
            <x-tall-errors :$errors :$fields />
        </x-slot>
        <x-slot name="actions">
            <div class="flex items-center">
                <x-tall-input.search wire:model.debounce.500ms="search" placeholder="{{ __('Search here') }}..."
                    type="text" />
            </div>
        </x-slot>
        {{-- @if ($fields)
            @foreach ($fields as $field)
                <x-tall-label :field="$field">
                    <x-dynamic-component component="tall-{{ $field->component }}" :field="$field" :model="$model" />
                    <x-tall-input-error :for="$field->key" />
                </x-tall-label>
            @endforeach
        @endif --}}
        @if ($menus = $this->menus)
            <ul class="space-y-1 font-inter font-medium w-full col-span-12">
                @foreach ($menus as $menu)
                    @if ($sub_menus = data_get($menu, 'sub_menus'))
                        @if ($sub_menus->count())
                            @include('tall::admin.tenants.menus.sub.items', ['items' => $sub_menus,'menu' => $menu])
                        @endif
                    @endif
                @endforeach
            </ul>
        @endif
    </x-tall-app-form>
</x-tall-app-form-main>
