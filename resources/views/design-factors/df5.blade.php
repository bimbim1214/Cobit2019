<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* Light theme */
        .light-card {
            background: white;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .light-input {
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            color: #1e293b;
        }

        .light-input:focus {
            background: white;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        /* DF5 Input Table Styling */
        .df5-input-table {
            border-collapse: collapse;
            width: 100%;
        }

        .df5-input-table th {
            background: #4a5d23;
            color: white;
            font-weight: 600;
            padding: 12px 16px;
            text-align: center;
            border: 1px solid #3d4d1c;
        }

        .df5-input-table td {
            padding: 12px 16px;
            border: 1px solid #c5d9a4;
            text-align: center;
        }

        .df5-input-table tr:nth-child(odd) td {
            background: #f0f7e6;
        }

        .df5-input-table tr:nth-child(even) td {
            background: white;
        }

        .df5-input-table td:first-child {
            text-align: left;
            font-weight: 600;
        }

        .df5-input-table .baseline-col {
            background: #e8f5d6 !important;
            color: #4a5d23;
            font-weight: 700;
        }

        /* Results Table */
        .results-table {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #1e2f13;
        }

        .results-table th {
            background-color: #375623 !important;
            color: #ffffff !important;
            font-weight: 700;
            padding: 12px 8px;
            text-align: center;
            border: 0.5px solid #1e2f13;
        }

        .results-table th:first-child {
            text-align: left;
            padding-left: 16px;
        }

        .results-table td {
            padding: 8px 12px;
            border: 0.5px solid #1e2f13;
            text-align: center;
            background-color: #e2efda;
            color: #000;
        }

        .results-table td:first-child {
            text-align: left;
            padding-left: 16px;
            font-weight: 500;
        }

        /* Badge Colors */
        .badge-edm {
            background: #3b82f6;
            color: white;
        }

        .badge-apo {
            background: #22c55e;
            color: white;
        }

        .badge-bai {
            background: #f59e0b;
            color: white;
        }

        .badge-dss {
            background: #a855f7;
            color: white;
        }

        .badge-mea {
            background: #ef4444;
            color: white;
        }

        /* Value Colors */
        .value-positive {
            color: #16a34a;
        }

        .value-negative {
            color: #dc2626;
        }

        .value-neutral {
            color: #64748b;
        }

        /* Validation */
        .validation-error {
            color: #dc2626;
            font-weight: 700;
        }

        .validation-success {
            color: #16a34a;
            font-weight: 700;
        }
    </style>

    <div class="min-h-screen py-8 bg-gray-100">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">

            <!-- Page Header -->
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-gray-800">DF5: Governance/Management Objectives</h1>
                <p class="mt-2 text-gray-600">Tailoring Governance System based on Design Factors</p>
            </div>

            <!-- Success Alert -->
            @if(session('success'))
                <div class="flex items-center p-4 mb-6 bg-green-100 border border-green-300 rounded-lg shadow-sm">
                    <svg class="w-5 h-5 mr-3 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-green-800">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Error Alert -->
            @if(session('error'))
                <div class="flex items-center p-4 mb-6 bg-red-100 border border-red-300 rounded-lg shadow-sm">
                    <svg class="w-5 h-5 mr-3 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-red-800">{{ session('error') }}</span>
                </div>
            @endif

            <form id="df5Form" action="{{ route('design-factors.df5.save') }}" method="POST">
                @csrf

                <!-- Section 1: Input Table -->
                <div class="mb-6 overflow-hidden light-card rounded-xl">
                    <div class="p-4 border-b border-gray-200 bg-slate-50">
                        <h2 class="text-xl font-bold text-green-600">Importance Input (100%)</h2>
                        <p class="mt-1 text-sm text-gray-600">Total harus sama dengan 100%</p>
                    </div>
                    <!-- Smart Message Box -->
                    <div id="smartMessageBox" class="mx-4 mt-4 p-3 rounded-lg border hidden">
                        <div class="flex items-center">
                            <div id="smartMessageIcon" class="mr-3"></div>
                            <div id="smartMessageContent" class="text-sm font-medium"></div>
                        </div>
                    </div>
                    <div class="p-4 bg-white">
                        <table class="df5-input-table">
                            <thead>
                                <tr>
                                    <th>Value</th>
                                    <th>Importance (100%)</th>
                                    <th>Baseline</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>High</td>
                                    <td>
                                        <input type="number" name="importance_high" id="importance_high"
                                            value="{{ $df5->importance_high ?? 50 }}" min="0" max="100" step="0.01"
                                            class="w-24 px-3 py-2 text-center font-bold bg-white border border-gray-300 rounded focus:outline-none focus:border-green-500"
                                            required>
                                        <span class="ml-1">%</span>
                                    </td>
                                    <td class="baseline-col">33%</td>
                                </tr>
                                <tr>
                                    <td>Normal</td>
                                    <td>
                                        <input type="number" name="importance_normal" id="importance_normal"
                                            value="{{ $df5->importance_normal ?? 50 }}" min="0" max="100" step="0.01"
                                            class="w-24 px-3 py-2 text-center font-bold bg-white border border-gray-300 rounded focus:outline-none focus:border-green-500"
                                            required>
                                        <span class="ml-1">%</span>
                                    </td>
                                    <td class="baseline-col">67%</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-right">
                                        <strong>Total: </strong>
                                        <span id="totalDisplay" class="text-lg font-bold">100.00%</span>
                                        <span id="validationMessage" class="ml-3"></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Section 2: Results Table -->
                <div class="mb-6 overflow-hidden light-card rounded-xl">
                    <div class="p-4 border-b border-gray-200 bg-slate-50">
                        <h2 class="text-xl font-bold text-green-600">Governance/Management Objectives</h2>
                        <p class="text-sm text-gray-600 mt-1">Resulting Governance/Management Objectives Importance</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="results-table" id="resultsTable">
                            <thead>
                                <tr>
                                    <th>Governance/Management Objective</th>
                                    <th>Score</th>
                                    <th>Baseline Score</th>
                                    <th>Relative Importance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($results as $result)
                                    <tr>
                                        <td>
                                            <span class="px-3 py-1 text-sm font-black rounded
                                                                                    @if(str_starts_with($result['code'], 'EDM')) badge-edm
                                                                                    @elseif(str_starts_with($result['code'], 'APO')) badge-apo
                                                                                    @elseif(str_starts_with($result['code'], 'BAI')) badge-bai
                                                                                    @elseif(str_starts_with($result['code'], 'DSS')) badge-dss
                                                                                    @elseif(str_starts_with($result['code'], 'MEA')) badge-mea
                                                                                    @endif">
                                                {{ $result['code'] }}
                                            </span>
                                            <span class="ml-2">{{ $result['name'] }}</span>
                                        </td>
                                        <td class="font-bold">{{ number_format($result['score'] / 100, 2) }}</td>
                                        <td class="font-bold">{{ number_format($result['baseline_score'] / 100, 2) }}</td>
                                        <td>
                                            <span class="font-black text-lg
                                                                                    @if($result['relative_importance'] > 0) value-positive
                                                                                    @elseif($result['relative_importance'] < 0) value-negative
                                                                                    @else value-neutral
                                                                                    @endif">
                                                {{ $result['relative_importance'] > 0 ? '+' : '' }}{{ (int) $result['relative_importance'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-gray-500">
                                            Tidak ada data
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Section 3: Charts -->
                <div class="grid grid-cols-1 gap-6 mb-6 lg:grid-cols-2">
                    <!-- Bar Chart -->
                    <div class="overflow-hidden light-card rounded-xl">
                        <div class="p-4 border-b border-gray-200 bg-slate-50">
                            <h2 class="text-xl font-bold text-green-600">DF5 Output (Bar Chart)</h2>
                            <p class="text-sm text-gray-600 mt-1">Resulting Governance/Management Objectives Importance
                            </p>
                        </div>
                        <div class="p-4 bg-white">
                            <div style="height: 800px;">
                                <canvas id="df5BarChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Radar Chart -->
                    <div class="overflow-hidden light-card rounded-xl">
                        <div class="p-4 border-b border-gray-200 bg-slate-50">
                            <h2 class="text-xl font-bold text-green-600">DF5 Threat Landscape</h2>
                            <p class="text-sm text-gray-600 mt-1">Resulting Governance/Management Objectives Importance
                            </p>
                        </div>
                        <div class="p-4 bg-white">
                            <div style="height: 800px;">
                                <canvas id="df5RadarChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-center gap-4 p-6 bg-slate-50 border border-gray-200 rounded-xl shadow-inner">
                    <button type="submit" id="saveBtn"
                        class="flex items-center px-10 py-4 text-base font-bold text-white bg-green-600 rounded-xl hover:bg-green-700 transform hover:scale-105 transition-all shadow-lg">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                            </path>
                        </svg>
                        Simpan DF5
                    </button>

                    <a href="{{ route('design-factors.index', 'DF1') }}"
                        class="flex items-center px-10 py-4 text-base font-bold text-gray-700 bg-gray-200 rounded-xl hover:bg-gray-300 transform hover:scale-105 transition-all shadow-lg">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18">
                            </path>
                        </svg>
                        Kembali ke DF
                    </a>
                </div>
            </form>

        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const highInput = document.getElementById('importance_high');
                const normalInput = document.getElementById('importance_normal');
                const totalDisplay = document.getElementById('totalDisplay');
                const validationMessage = document.getElementById('validationMessage');
                const saveBtn = document.getElementById('saveBtn');

                function updateSmartMessage(high, normal, total, lastTarget) {
                    const smartBox = document.getElementById('smartMessageBox');
                    const smartIcon = document.getElementById('smartMessageIcon');
                    const smartContent = document.getElementById('smartMessageContent');
                    
                    if (!smartBox) return;
                    smartBox.classList.remove('hidden');

                    if (Math.abs(total - 100) < 0.01) {
                        smartBox.className = 'mx-4 mt-4 p-3 rounded-lg border bg-green-50 border-green-200 text-green-800';
                        smartIcon.innerHTML = '<svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>';
                        smartContent.innerText = 'Total sudah tepat 100%. Data siap disimpan.';
                    } else if (total > 100) {
                        smartBox.className = 'mx-4 mt-4 p-3 rounded-lg border bg-red-50 border-red-200 text-red-800';
                        smartIcon.innerHTML = '<svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>';
                        smartContent.innerText = `Total (${total.toFixed(2)}%) melebihi 100%! Mohon kurangi nilai agar pas 100%.`;
                    } else {
                        // total < 100
                        smartBox.className = 'mx-4 mt-4 p-3 rounded-lg border bg-blue-50 border-blue-200 text-blue-800';
                        smartIcon.innerHTML = '<svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>';
                        
                        let suggestion = '';
                        if (lastTarget === 'high') {
                            const needed = 100 - high;
                            suggestion = `Saran: Jika 'High' diisi ${high}%, maka isi 'Normal' dengan ${needed.toFixed(2)}% agar total 100%.`;
                        } else {
                            const needed = 100 - normal;
                            suggestion = `Saran: Jika 'Normal' diisi ${normal}%, maka isi 'High' dengan ${needed.toFixed(2)}% agar total 100%.`;
                        }
                        smartContent.innerText = suggestion;
                    }
                }

                function updateTotal(lastTarget = 'high') {
                    const high = parseFloat(highInput.value) || 0;
                    const normal = parseFloat(normalInput.value) || 0;
                    const total = high + normal;

                    totalDisplay.textContent = total.toFixed(2) + '%';
                    updateSmartMessage(high, normal, total, lastTarget);

                    if (Math.abs(total - 100) < 0.01) {
                        validationMessage.innerHTML = '<span class="validation-success">✓ Valid</span>';
                        saveBtn.disabled = false;
                        saveBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    } else {
                        validationMessage.innerHTML = '<span class="validation-error">✗ Total harus tepat 100%</span>';
                        saveBtn.disabled = true;
                        saveBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    }
                }

                function autoCalculate() {
                    const high = parseFloat(highInput.value) || 0;
                    const normal = parseFloat(normalInput.value) || 0;

                    // Auto-calculate on input change
                    fetch('{{ route('design-factors.df5.calculate') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            importance_high: high,
                            importance_normal: normal
                        })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                updateResultsTable(data.results);
                                updateCharts(data.results);
                            }
                        })
                        .catch(error => {
                            console.error('Auto-calculate error:', error);
                        });
                }

                // Update total and auto-calculate on input change
                highInput.addEventListener('input', function () {
                    updateTotal('high');
                    autoCalculate();
                });

                normalInput.addEventListener('input', function () {
                    updateTotal('normal');
                    autoCalculate();
                });

                function updateResultsTable(results) {
                    const tbody = document.querySelector('#resultsTable tbody');
                    tbody.innerHTML = '';

                    results.forEach(result => {
                        const badgeClass = getBadgeClass(result.code);
                        const valueClass = result.relative_importance > 0 ? 'value-positive' :
                            (result.relative_importance < 0 ? 'value-negative' : 'value-neutral');
                        const sign = result.relative_importance > 0 ? '+' : '';

                        const row = `
                                                            <tr>
                                                                <td>
                                                                    <span class="px-3 py-1 text-sm font-black rounded ${badgeClass}">
                                                                        ${result.code}
                                                                    </span>
                                                                    <span class="ml-2">${result.name}</span>
                                                                </td>
                                                                <td class="font-bold">${(parseFloat(result.score) / 100).toFixed(2)}</td>
                                                                <td class="font-bold">${(parseFloat(result.baseline_score) / 100).toFixed(2)}</td>
                                                                <td>
                                                                    <span class="font-black text-lg ${valueClass}">
                                                                        ${sign}${Math.round(result.relative_importance)}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                        `;
                        tbody.innerHTML += row;
                    });
                }

                function getBadgeClass(code) {
                    if (code.startsWith('EDM')) return 'badge-edm';
                    if (code.startsWith('APO')) return 'badge-apo';
                    if (code.startsWith('BAI')) return 'badge-bai';
                    if (code.startsWith('DSS')) return 'badge-dss';
                    if (code.startsWith('MEA')) return 'badge-mea';
                    return '';
                }

                // Chart.js initialization
                let barChart = null;
                let radarChart = null;

                function initCharts() {
                    const barCtx = document.getElementById('df5BarChart').getContext('2d');
                    const radarCtx = document.getElementById('df5RadarChart').getContext('2d');

                    // Get initial data from results
                    const results = @json($results);
                    const chartLabels = results.map(r => r.code);
                    const chartData = results.map(r => r.relative_importance);

                    // Bar Chart
                    barChart = new Chart(barCtx, {
                        type: 'bar',
                        data: {
                            labels: chartLabels,
                            datasets: [{
                                label: 'Relative Importance',
                                data: chartData,
                                backgroundColor: chartData.map(v => v >= 0 ? 'rgba(79, 124, 53, 0.7)' : 'rgba(192, 0, 0, 0.7)'),
                                borderColor: chartData.map(v => v >= 0 ? 'rgba(79, 124, 53, 1)' : 'rgba(192, 0, 0, 1)'),
                                borderWidth: 1
                            }]
                        },
                        options: {
                            indexAxis: 'y',
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    callbacks: {
                                        label: function (context) {
                                            return 'Relative Importance: ' + context.parsed.x;
                                        }
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    min: -100,
                                    max: 100,
                                    grid: { color: '#e5e7eb' },
                                    ticks: { stepSize: 25 }
                                },
                                y: {
                                    grid: { display: true, borderDash: [5, 5], color: '#e5e7eb' },
                                    ticks: { font: { weight: 'bold' }, autoSkip: false }
                                }
                            }
                        }
                    });

                    // Radar Chart
                    radarChart = new Chart(radarCtx, {
                        type: 'radar',
                        data: {
                            labels: chartLabels,
                            datasets: [{
                                label: 'Relative Importance',
                                data: chartData.map(v => v + 100),
                                backgroundColor: 'rgba(229, 180, 229, 0.3)',
                                borderColor: 'rgba(229, 180, 229, 1)',
                                borderWidth: 2,
                                pointBackgroundColor: 'rgba(229, 180, 229, 1)',
                                pointRadius: 2
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: { legend: { display: false } },
                            scales: {
                                r: {
                                    min: 0,
                                    max: 200,
                                    ticks: {
                                        stepSize: 25,
                                        callback: v => v - 100,
                                        backdropColor: 'transparent'
                                    },
                                    pointLabels: {
                                        font: { size: 10, weight: 'bold' }
                                    }
                                }
                            }
                        }
                    });
                }

                function updateCharts(results) {
                    if (!barChart || !radarChart) return;

                    const chartLabels = results.map(r => r.code);
                    const chartData = results.map(r => r.relative_importance);

                    // Update Bar Chart
                    barChart.data.labels = chartLabels;
                    barChart.data.datasets[0].data = chartData;
                    barChart.data.datasets[0].backgroundColor = chartData.map(v => v >= 0 ? 'rgba(79, 124, 53, 0.7)' : 'rgba(192, 0, 0, 0.7)');
                    barChart.data.datasets[0].borderColor = chartData.map(v => v >= 0 ? 'rgba(79, 124, 53, 1)' : 'rgba(192, 0, 0, 1)');
                    barChart.update('none');

                    // Update Radar Chart
                    radarChart.data.labels = chartLabels;
                    radarChart.data.datasets[0].data = chartData.map(v => v + 100);
                    radarChart.update('none');
                }

                // Initialize charts on page load
                initCharts();

                // Initial validation
                updateTotal();
            });
        </script>
    @endpush
</x-app-layout>