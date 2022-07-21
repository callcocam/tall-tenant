<div class="mx-auto rounded-md flex items-center">
    <div class="flex flex-col text-gray-800 text-center sm:text-left w-full">
        <section class="flex w-full items-center">
            <h1 class="text-3xl font-bold mb-2 whitespace-nowrap">
                {{ __('TALL-Tenants') }}
            </h1>
            <!-- BEGIN: breadcrums v1 -->
            <div class="container flex items-center justify-start">
                <div class="pl-3 text-sm breadcrumbs text-primary flex-1">
                    <ul class="flex w-full space-x-3">
                        <li class="flex">
                            @if (\Route::has('home'))
                                <a href="{{ route('home') }}">
                                    <i class="swfa fas fa-home ml-2" aria-hidden="true"></i>
                                    <span class="ml-3">{{ __('Dashboard') }}</span>
                                </a>
                            @else
                                <a href="{{ url('/') }}">
                                    <i class="swfa fas fa-home ml-2" aria-hidden="true"></i>
                                    <span class="ml-3">{{ __('Dashboard') }}</span>
                                </a>
                            @endif
                        </li>
                        @isset($url)
                            <li class="flex justify-items-start items-center text-sky-900">
                                <a class="flex items-center" href="{{ $url }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                    {{ __('Listar') }}
                                </a>
                            </li>
                        @endisset
                        @isset($back)
                            <li class="flex justify-items-start items-center text-sky-900">
                                <a class="flex items-center" href="{{ $back }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                    {{ __($backlabel) }}
                                </a>
                            </li>
                        @endisset
                        <li class="flex justify-items-start items-center text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                            </svg>
                            {{ $label }}
                        </li>
                    </ul>
                </div>
            </div> <!-- END: breadcrums v1 -->
        </section>
    </div>
</div>
