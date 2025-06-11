@props(['route', 'label', 'segment'])

<li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 @if(Request::is($segment.'*')) bg-damu-100 dark:bg-damu-500/20 @endif">
    <a class="block text-gray-800 dark:text-gray-100 truncate transition hover:text-gray-900 dark:hover:text-white" href="{{ $route }}">
        <div class="flex items-center">
            <div class="shrink-0 h-4 w-4">
                {{ $slot }}
            </div>
            <span class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">{{ $label }}</span>
        </div>
    </a>
</li>