<x-filament-panels::page class="fi-dashboard-page">
    @if (method_exists($this, 'filtersForm'))
        {{ $this->filtersForm }}
    @endif

    <div class="flex flex-col">
        <h1 class="text-4xl font-bold mb-4">Welcome to the Dashboard!</h1>
        <div class="text-8xl font-bold">
            <span id="clock"></span>
        </div>
    </div>

    @push('scripts')
        <script>
            function updateClock() {
                const now = new Date();
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const seconds = String(now.getSeconds()).padStart(2, '0');
                const time = `${hours}:${minutes}:${seconds}`;
                document.getElementById('clock').textContent = time;
            }

            setInterval(updateClock, 1000);
        </script>
    @endpush

    <x-filament-widgets::widgets
        :columns="$this->getColumns()"
        :data="
            [
                ...(property_exists($this, 'filters') ? ['filters' => $this->filters] : []),
                ...$this->getWidgetData(),
            ]
        "
        :widgets="$this->getVisibleWidgets()"
    />
</x-filament-panels::page>
