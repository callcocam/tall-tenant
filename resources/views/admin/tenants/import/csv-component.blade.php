<x-tall-app-import :importAttr="$importAttr">

    <div class="flex flex-col sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5"
        x-on:dragover.prevent="dropping = true" x-on:dragleave.prevent="dropping = false" x-on:drop="dropping = false"
        x-on:drop.prevent="handleDrop($event)" x-data="{
            dropping: false,
        
            handleDrop(event) {
                @this.upload('file', event.dataTransfer.files[0])
            }
        
        }">
        <div class="mt-1 sm:mt-0 w-full">
            <div class="flex w-full justify-center rounded-md border-2 border-dashed px-6 pt-5 pb-6"
                x-bind:class="{
                
                    'border-gray-300': !dropping,
                
                
                    'border-gray-400': dropping
                
                }">
                <div class="space-y-1 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0112 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M12 10.875v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125M13.125 12h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125M20.625 12c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5M12 14.625v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 14.625c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m0 1.5v-1.5m0 0c0-.621.504-1.125 1.125-1.125m0 0h7.5" />
                    </svg>
                    <div class="flex text-sm text-gray-600">
                        <label for="file-upload"
                            class="relative cursor-pointer rounded-md  font-medium text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:text-indigo-500">
                            <span>{{ __('Upload a file') }}</span>
                            <input wire:model="file" id="file-upload" name="file-upload" type="file" class="sr-only">
                        </label>
                        <p class="pl-1">{{ __('or drag and drop') }}</p>
                    </div>
                    <p class="text-xs text-gray-500">CSV 5MB</p>
                </div>
            </div>
        </div>
        @error('file')
            <div class="mt-2 text-red-500 font-medium text-sm">
                {{ $message }}
            </div>
        @enderror
    </div>
    @if ($fileHeaders)
        @if ($columnMaps)
            @foreach ($columnMaps as $column => $value)
                <label class="block">
                    <span>{{ $column }}
                        @if (\Arr::has($requiredColumnMaps, $column))
                            <span class="text-red-600">*</span>
                        @endif
                    </span>
                    <select wire:model="columnMaps.{{ $column }}"
                        class="form-select mt-1 h-8 w-full rounded-lg border border-slate-300 bg-white px-2.5 text-xs+ hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                        <option>{{ __('Selecione') }}</option>
                        @foreach ($fileHeaders as $header)
                            <option value="{{ $header }}">{{ $header }}</option>
                        @endforeach
                    </select>
                    @error(sprintf('columnMaps.%s', $column))
                        <div class="mt-2 text-red-500 font-medium text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </label>
            @endforeach
        @endif
    @endif
    <x-slot name="actions">
        @if ($fileHeaders)
            <div class="flex space-x-1">
                <button type="button"
                    class="btn h-8 w-8 rounded-full p-0 text-error hover:bg-error/20 focus:bg-error/20 active:bg-error/25">
                    <x-tall-icon name="trash" />
                </button>
                <button type="button"
                    class="btn h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                    <x-tall-icon name="arrow-top-right-on-square" />
                </button>
            </div>
            <x-tall-secondary-button type="submit">
                {{ __('Import') }}
            </x-tall-secondary-button>
        @endif
    </x-slot>
</x-tall-app-import>
