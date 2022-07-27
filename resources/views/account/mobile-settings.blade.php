<div class="flex items-center px-4">
    @include('tenant::account.mobile-profile-photos')
    <div>
        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
    </div>
</div>
