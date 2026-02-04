<x-app-layout>
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="min-h-screen py-8 bg-gray-100">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">

            <!-- Page Header -->
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-gray-800">Design Factor Canvas</h1>
                <p class="mt-2 text-gray-600">Tailored Governance System based on aggregated Design Factors (1-10)</p>
            </div>

            <!-- Navigation Tabs -->
            <div class="flex flex-wrap justify-center gap-2 mb-8">
                @php
                    $mainTabs = [
                        'DF1' => 'DF1: Enterprise Strategy',
                        'DF2' => 'DF2: Enterprise Goals',
                        'DF3' => 'DF3: Risk Profile',
                        'DF4' => 'DF4: IT-Related Issues',
                    ];
                @endphp

                @foreach($mainTabs as $tabType => $tabLabel)
                    @php
                        $isAccessible = isset($progress[$tabType]) && $progress[$tabType]['accessible'];
                        $isCompleted = isset($progress[$tabType]) && $progress[$tabType]['completed'];
                    @endphp
                    <a href="{{ $isAccessible ? route('design-factors.index', $tabType) : '#' }}" class="px-6 py-2 text-sm font-bold rounded-full transition-all inline-flex items-center gap-2
                                bg-white text-gray-600 hover:bg-gray-200" {{ !$isAccessible ? 'onclick="return false;"' : '' }}>
                        {{ $tabLabel }}
                        @if($isCompleted)
                            <span class="text-lg">✅</span>
                        @endif
                    </a>
                @endforeach

                {{-- Summary Tab (Active) --}}
                <a href="#"
                    class="px-6 py-2 text-sm font-bold rounded-full transition-all inline-flex items-center gap-2 bg-green-600 text-white shadow-lg">
                    Summary
                </a>

                {{-- DF5 Tab --}}
                @php
                    $df5Accessible = isset($progress['DF5']) && $progress['DF5']['accessible'];
                    $df5Completed = isset($progress['DF5']) && $progress['DF5']['completed'];
                @endphp
                <a href="{{ $df5Accessible ? route('design-factors.index', 'DF5') : '#' }}"
                    class="px-6 py-2 text-sm font-bold rounded-full transition-all inline-flex items-center gap-2
                    {{ $df5Accessible ? 'bg-white text-gray-600 hover:bg-gray-200' : 'bg-gray-300 text-gray-500 cursor-not-allowed opacity-60' }}" {{ !$df5Accessible ? 'onclick="return false;"' : '' }}>
                    DF5: Governance Obj.
                    @if($df5Completed)
                        <span class="text-lg">✅</span>
                    @endif
                </a>

                @php
                    $otherTabs = [
                        'DF6' => 'DF6: Threat Landscape',
                        'DF7' => 'DF7: Importance of Role of IT',
                        'DF8' => 'DF8: Sourcing Model',
                        'DF9' => 'DF9: IT Implementation',
                        'DF10' => 'DF10: Tech Adoption',
                    ];
                @endphp

                @foreach($otherTabs as $tabType => $tabLabel)
                    <a href="{{ route('design-factors.index', $tabType) }}"
                        class="px-6 py-2 text-sm font-bold rounded-full transition-all bg-white text-gray-600 hover:bg-gray-200">
                        {{ $tabLabel }}
                    </a>
                @endforeach
            </div>

            <!-- Canvas Chart -->
            <div class="mb-8 overflow-hidden bg-white border border-gray-200 shadow-sm rounded-xl">
                <div class="p-6 border-b border-gray-200 bg-slate-50">
                    <h2 class="text-xl font-bold text-gray-800">Final Aggregated Importance</h2>
                    <p class="text-sm text-gray-600">Sum of relative importance scores from all Design Factors.</p>
                </div>
                <div class="p-6">
                    <div class="relative" style="height: 600px;">
                        <canvas id="summaryCanvas"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const ctx = document.getElementById('summaryCanvas').getContext('2d');
                const results = @json($results);
                const labels = Object.keys(results);
                const data = Object.values(results);

                // Determine bar colors based on value
                const backgroundColors = data.map(value => value >= 0 ? 'rgba(75, 192, 192, 0.6)' : 'rgba(255, 99, 132, 0.6)');
                const borderColors = data.map(value => value >= 0 ? 'rgba(75, 192, 192, 1)' : 'rgba(255, 99, 132, 1)');

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Relative Importance Score',
                            data: data,
                            backgroundColor: backgroundColors,
                            borderColor: borderColors,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        indexAxis: 'y', // Horizontal bars for readability of 40 items
                        scales: {
                            x: {
                                beginAtZero: true,
                                grid: { color: '#e5e7eb' }
                            },
                            y: {
                                grid: { display: false },
                                ticks: {
                                    font: { size: 11 }
                                }
                            }
                        },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: function (context) {
                                        return context.dataset.label + ': ' + context.raw;
                                    }
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>