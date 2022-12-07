<li x-data="{ expanded: false }" class="w-full">
    <div tabindex="0" :class="expanded && 'text-slate-800 dark:text-navy-100'"
        class="flex cursor-pointer items-center space-x-1.5 rounded px-2 py-1 tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
        <button @click="expanded = !expanded"
            class="btn h-5 w-5 rounded-lg p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 transition-transform"
                :class="expanded && 'rotate-90'" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                    clip-rule="evenodd"></path>
            </svg>
        </button>
        <span>{{ data_get($menu, 'name') }}</span>
    </div>
    <ul x-show="expanded" x-collapse class="pl-4 w-full">
        @foreach ($items as $sub_menu)
            @if ($sub_items = data_get($sub_menu, 'sub_menus'))
                @if ($sub_items->count())
                    @include('tall::admin.tenants.menus.sub.items', ['items' => $sub_items,'menu' => $sub_menu])
                @else
                    @include('tall::admin.tenants.menus.sub.item', ['item' => $sub_menu])
                @endif
            @endif
        @endforeach
    </ul>
</li>
