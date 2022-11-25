@if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
    <div class="border-t border-gray-200"></div>

    <div class="block px-4 py-2 text-xs text-gray-400">
        {{ __('Manage Team') }}
    </div>

    <!-- Team Settings -->
    <x-jet-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
        {{ __('Team Settings') }}
    </x-jet-responsive-nav-link>

    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
        <x-jet-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
            {{ __('Create New Team') }}
        </x-jet-responsive-nav-link>
    @endcan

    <div class="border-t border-gray-200"></div>

    <!-- Team Switcher -->
    <div class="block px-4 py-2 text-xs text-gray-400">
        {{ __('Switch Teams') }}
    </div>

    @foreach (Auth::user()->allTeams() as $team)
        <x-jet-switchable-team :team="$team" component="jet-responsive-nav-link" />
    @endforeach
@endif
