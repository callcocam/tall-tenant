@if ($route = config('acl.routes.users.list'))
<x-jet-responsive-nav-link href="{{ route($route) }}" :active="request()->routeIs($route)">
    {{ __('Users') }}
</x-jet-responsive-nav-link>
@endif

@if ($route = config('acl.routes.roles.list'))
<x-jet-responsive-nav-link href="{{ route($route) }}" :active="request()->routeIs($route)">
    {{ __('Roles') }}
</x-jet-responsive-nav-link>
@endif

@if ($route = config('acl.routes.permissions.list'))
<x-jet-responsive-nav-link href="{{ route($route) }}" :active="request()->routeIs($route)">
    {{ __('Permisions') }}
</x-jet-responsive-nav-link>
@endif

@if ($route = config('menus.routes.menus.list'))
<x-jet-responsive-nav-link href="{{ route($route) }}" :active="request()->routeIs($route)">
    {{ __('Menus') }}
</x-jet-responsive-nav-link>
@endif

@if ($route = config('report.routes.reports.list'))
<x-jet-responsive-nav-link href="{{ route($route) }}" :active="request()->routeIs($route)">
    {{ __('Reports') }}
</x-jet-responsive-nav-link>
@endif
<x-jet-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
    {{ __('Profile') }}
</x-jet-responsive-nav-link>

@if (Laravel\Jetstream\Jetstream::hasApiFeatures())
    <x-jet-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
        {{ __('API Tokens') }}
    </x-jet-responsive-nav-link>
@endif

<!-- Authentication -->
<form method="POST" action="{{ route('logout') }}" x-data>
    @csrf
    <x-jet-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
        {{ __('Log Out') }}
    </x-jet-responsive-nav-link>
</form>