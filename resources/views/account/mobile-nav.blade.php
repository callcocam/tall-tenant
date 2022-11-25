<x-jet-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
    {{ __('Dashboard') }}
</x-jet-responsive-nav-link>
<x-jet-responsive-nav-link href="{{ route(routeTenant()) }}" :active="request()->routeIs(routeTenant())">
    {{ __('Tenants') }}
</x-jet-responsive-nav-link>