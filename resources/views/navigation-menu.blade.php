<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-jet-application-mark class="block h-9 w-auto" />
                    </a>
                </div>
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    @includeIf('tall-tenant::account.nav')
                </div>
            </div>
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <!-- Teams Dropdown -->
                @includeIf('tall-tenant::teams.desktop')
                <!-- Settings Dropdown -->
                <div class="ml-3 relative">
                    <x-jet-dropdown align="right" width="48">
                        @includeIf('tall-tenant::account.profile-photos')
                        @includeIf('tall-tenant::account.desktop')
                    </x-jet-dropdown>
                </div>
            </div>
            <!-- Hamburger -->
            @includeIf('tall-tenant::account.settings')
        </div>
    </div>
    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @includeIf('tall-tenant::account.mobile-nav')
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            @includeIf('tall-tenant::account.mobile-settings')
            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                @includeIf('tall-tenant::account.mobile')
                <!-- Team Management -->
                @includeIf('tall-tenant::teams.mobile')
            </div>
        </div>
    </div>
</nav>
