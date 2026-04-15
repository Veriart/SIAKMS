<x-filament::widget>
    <x-filament::card>

        <div class="grid grid-cols-3 gap-4">

            {{-- Chart --}}
            <div class="col-span-2">
                @livewire(\App\Filament\Widgets\StatsDashboard::class)
            </div>

            {{-- Stats --}}
            <div class="space-y-4">
                @livewire(\App\Filament\Widgets\ChartDashboard::class)
            </div>

        </div>

    </x-filament::card>
</x-filament::widget>