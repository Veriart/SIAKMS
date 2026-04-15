<x-filament-widgets::widget>
    <x-filament::section class="border-l-4 border-l-primary-500 rounded-lg shadow-sm w-full bg-white dark:bg-gray-900 flex items-center p-6">
        <div class="flex items-center gap-x-4 w-full">
            @php
                $avatarUrl = filament()->auth()->user()->getFilamentAvatarUrl();
                $userName = filament()->auth()->user()->name;
                $roles = filament()->auth()->user()->roles->pluck('name')->join(', ');
            @endphp
            
            @if ($avatarUrl)
                <x-filament::avatar
                    src="{{ $avatarUrl }}"
                    alt="{{ $userName }}"
                    size="xl"
                    class="h-16 w-16 !bg-cover"
                />
            @else
                <div class="flex items-center justify-center w-16 h-16 rounded-full bg-primary-100 text-primary-600 font-bold text-2xl shadow-inner">
                    {{ substr($userName, 0, 1) }}
                </div>
            @endif

            <div class="flex flex-col ml-2 space-y-1">
                <h2 class="text-2xl font-bold tracking-tight text-gray-950 dark:text-white">
                    {{ $this->getGreeting() }}, {{ $userName }}! 👋
                </h2>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mt-1">
                    Anda login sebagai <span class="px-2 py-0.5 rounded-md bg-primary-50 text-primary-600 dark:bg-primary-900/50 dark:text-primary-400 font-semibold">{{ $roles ?: 'Pengguna' }}</span>. Selamat datang di Sistem Informasi Akademik.
                </p>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
