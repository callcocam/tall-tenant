<x-jet-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
    {{ __('Dashboard') }}
</x-jet-nav-link>
<x-jet-nav-link href="{{ route(routeTenant()) }}" :active="request()->routeIs(routeTenant())">
    {{ __('Tenants') }}
</x-jet-nav-link>
