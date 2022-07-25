<x-slot name="content">
    <!-- Account Management -->
    <div class="block px-4 py-2 text-xs text-gray-400">
        {{ __('Manage Account') }}
    </div>

    <x-jet-dropdown-link href="{{ route('profile.show') }}">
        {{ __('Profile') }}
    </x-jet-dropdown-link>
    @if ($route = config('acl.routes.users.list'))
        @if (\Route::has($route))
            <x-jet-dropdown-link href="{{ route($route) }}">
                {{ __('Users') }}
            </x-jet-dropdown-link>
        @endif
    @endif

    @if ($route = config('acl.routes.roles.list'))
        @if (\Route::has($route))
            <x-jet-dropdown-link href="{{ route($route) }}">
                {{ __('Roles') }}
            </x-jet-dropdown-link>
        @endif
    @endif

    @if ($route = config('acl.routes.permissions.list'))
        @if (\Route::has($route))
            <x-jet-dropdown-link href="{{ route($route) }}">
                {{ __('Permisions') }}
            </x-jet-dropdown-link>
        @endif
    @endif

    @if ($route = config('menus.routes.menus.list'))
        @if (\Route::has($route))
            <x-jet-dropdown-link href="{{ route($route) }}">
                {{ __('Menus') }}
            </x-jet-dropdown-link>
        @endif
    @endif

    @if ($route = config('report.routes.reports.list'))
        @if (\Route::has($route))
            <x-jet-dropdown-link href="{{ route($route) }}">
                {{ __('Reports') }}
            </x-jet-dropdown-link>
        @endif
    @endif

    @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
        <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
            {{ __('API Tokens') }}
        </x-jet-dropdown-link>
    @endif

    <div class="border-t border-gray-100"></div>

    <!-- Authentication -->
    <form method="POST" action="{{ route('logout') }}" x-data>
        @csrf

        <x-jet-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
            {{ __('Log Out') }}
        </x-jet-dropdown-link>
    </form>
</x-slot>
