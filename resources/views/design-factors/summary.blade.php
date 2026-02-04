<x-app-layout>
    <style>
        /* Light theme */
        .light-card {
            background: white;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        /* Summary Table Styling */
        .summary-table {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #1e2f13;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .summary-table th {
            background-color: #375623 !important;
            color: #ffffff !important;
            font-weight: 700;
            padding: 12px 8px;
            text-align: center;
            border: 0.5px solid #1e2f13;
            font-size: 0.9rem;
            vertical-align: middle;
        }

        .summary-table th:first-child {
            text-align: left;
            padding-left: 16px;
        }

        .summary-table td {
            padding: 10px 12px;
            border: 0.5px solid #1e2f13;
            text-align: center;
            background-color: #e2efda;
            color: #000;
            font-size: 0.9rem;
        }

        .summary-table td:first-child {
            text-align: left;
            padding-left: 16px;
            font-weight: 500;
        }

        .summary-table td.value-positive {
            color: #16a34a;
            font-weight: 700;
        }

        .summary-table td.value-negative {
            color: #dc2626;
            font-weight: 700;
        }

        .summary-table td.value-neutral {
            color: #64748b;
            font-weight: 700;
        }

        .summary-table td.initial-scope-positive {
            background-color: #70ad47 !important;
            color: #ffffff !important;
            font-weight: 700;
        }

        .summary-table td.initial-scope-negative {
            background-color: #c00000 !important;
            color: #ffffff !important;
            font-weight: 700;
        }

        .summary-table td.initial-scope-neutral {
            background-color: #ffc000 !important;
            color: #000000 !important;
            font-weight: 700;
        }

        /* Badge Domain Colors */
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
    </style>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="min-h-screen py-8 bg-gray-100">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">

            <!-- Page Header -->
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-gray-800">Kalkulator COBIT Relative Importance</h1>
                <p class="mt-2 text-gray-600">Tailoring Governance System based on Design Factors</p>
            </div>

            <!-- Progress Bar -->
            @php
                // Progress based on all 10 DFs
                $completedCount = 0;
                $allDfs = ['DF1', 'DF2', 'DF3', 'DF4', 'DF5', 'DF6', 'DF7', 'DF8', 'DF9', 'DF10'];
                foreach ($allDfs as $df) {
                    if (isset($progress[$df]) && $progress[$df]['completed']) {
                        $completedCount++;
                    }
                }
                // If Summary is locked, we can assume DF1-DF4 is done.
                // But for progress bar, let's just count total completed.
                $progressPercent = ($completedCount / 10) * 100;
            @endphp
            <div class="mb-6 bg-white rounded-xl shadow-sm p-4">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-semibold text-gray-700">Progress Keseluruhan</span>
                    <span class="text-sm font-bold text-green-600">{{ number_format($progressPercent, 0) }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="bg-green-600 h-3 rounded-full transition-all duration-500"
                        style="width: {{ $progressPercent }}%"></div>
                </div>
            </div>

            <!-- Design Factor Tabs -->
            <div class="flex flex-wrap justify-center gap-2 mb-8">
                @php
                    $allTabs = [
                        'DF1' => 'DF1',
                        'DF2' => 'DF2',
                        'DF3' => 'DF3',
                        'DF4' => 'DF4',
                    ];
                @endphp

                @foreach($allTabs as $tabType => $tabLabel)
                    @php
                        $isAccessible = isset($progress[$tabType]) && $progress[$tabType]['accessible'];
                        $isCompleted = isset($progress[$tabType]) && $progress[$tabType]['completed'];
                    @endphp
                    <a href="{{ $isAccessible ? route('design-factors.index', $tabType) : '#' }}"
                        class="px-5 py-2 text-xs font-bold rounded-full transition-all inline-flex items-center gap-1
                            {{ $isAccessible ? 'bg-white text-gray-600 hover:bg-gray-200 shadow-sm border border-gray-100' : 'bg-gray-300 text-gray-500 cursor-not-allowed opacity-60' }}"
                        {{ !$isAccessible ? 'onclick="return false;"' : '' }}>
                        {{ $tabLabel }}
                        @if($isCompleted)
                            <span class="text-xs">✅</span>
                        @endif
                    </a>
                @endforeach

                {{-- Summary Tab (Active) --}}
                <a href="{{ route('design-factors.summary') }}"
                    class="px-5 py-2 text-xs font-bold rounded-full transition-all bg-green-600 text-white shadow-lg border border-green-700">
                    Summary
                </a>

                {{-- Other DFs --}}
                @php
                    $otherTabsList = [
                        'DF5' => 'DF5',
                        'DF6' => 'DF6',
                        'DF7' => 'DF7',
                        'DF8' => 'DF8',
                        'DF9' => 'DF9',
                        'DF10' => 'DF10',
                    ];
                @endphp

                @foreach($otherTabsList as $tabType => $tabLabel)
                    @php
                        $isAccessible = isset($progress[$tabType]) && $progress[$tabType]['accessible'];
                        $isCompleted = isset($progress[$tabType]) && $progress[$tabType]['completed'];
                        $route = ($tabType === 'DF5') ? route('design-factors.index', 'DF5') : route('design-factors.index', $tabType);
                    @endphp
                    <a href="{{ $isAccessible ? $route : '#' }}"
                        class="px-5 py-2 text-xs font-bold rounded-full transition-all inline-flex items-center gap-1 
                        {{ $isAccessible ? 'bg-white text-gray-600 hover:bg-gray-200 shadow-sm border border-gray-100' : 'bg-gray-300 text-gray-500 cursor-not-allowed opacity-60' }}" {{ !$isAccessible ? 'onclick="return false;"' : '' }}>
                        {{ $tabLabel }}
                        @if($isCompleted)
                            <span class="text-xs">✅</span>
                        @endif
                    </a>
                @endforeach
            </div>

            <!-- Summary Chart -->
            <div class="mb-6 overflow-hidden light-card rounded-xl shadow-sm">
                <div class="p-4 border-b border-gray-200 bg-slate-50">
                    <h2 class="text-xl font-bold text-green-600">Step 2 Initial Design</h2>
                    <p class="text-sm text-gray-600 mt-1">Governance and Management Objectives Importance</p>
                </div>

                <div class="p-6 bg-white">
                    <div class="relative" style="height: 1200px;">
                        <canvas id="summaryChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Summary Table -->
            <div class="mb-6 overflow-hidden light-card rounded-xl shadow-sm">
                <div class="p-4 border-b border-gray-200 bg-slate-50">
                    <h2 class="text-xl font-bold text-green-600">Step 2: Determine the Initial Scope of the Governance
                        System</h2>
                </div>

                <div class="p-4 bg-white overflow-x-auto">
                    <table class="summary-table">
                        <thead>
                            <tr>
                                <th style="min-width: 400px;">Design Factors</th>
                                <th>DF1</th>
                                <th>DF2</th>
                                <th>DF3</th>
                                <th>DF4</th>
                                <th style="min-width: 150px;">Initial Scope Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($summaryData as $row)
                                <tr>
                                    <td>
                                        <span class="px-3 py-1 text-sm font-black rounded
                                                                                                    @if(str_starts_with($row['code'], 'EDM')) badge-edm
                                                                                                    @elseif(str_starts_with($row['code'], 'APO')) badge-apo
                                                                                                    @elseif(str_starts_with($row['code'], 'BAI')) badge-bai
                                                                                                    @elseif(str_starts_with($row['code'], 'DSS')) badge-dss
                                                                                                    @elseif(str_starts_with($row['code'], 'MEA')) badge-mea
                                                                                                    @endif">
                                            {{ $row['code'] }}
                                        </span>
                                        <span class="ml-2">{{ $row['name'] }}</span>
                                    </td>
                                    @foreach(['df1', 'df2', 'df3', 'df4'] as $dfKey)
                                        <td class="
                                            @if($row[$dfKey] > 0) value-positive
                                            @elseif($row[$dfKey] < 0) value-negative
                                            @else value-neutral
                                            @endif">
                                            {{ $row[$dfKey] > 0 ? '+' : '' }}{{ (int) $row[$dfKey] }}
                                        </td>
                                    @endforeach
                                    <td class="
                                        @if($row['initial_scope'] > 0) initial-scope-positive
                                        @elseif($row['initial_scope'] < 0) initial-scope-negative
                                        @else initial-scope-neutral
                                        @endif">
                                        {{ $row['initial_scope'] > 0 ? '+' : '' }}{{ (int) $row['initial_scope'] }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Info Box -->
            <div class="p-6 bg-blue-50 border border-blue-200 rounded-xl shadow-sm mb-6">
                <h3 class="text-lg font-bold text-blue-800 mb-2">📊 Summary Information</h3>
                <p class="text-blue-700">
                    This summary aggregates the relative importance scores from the first four Design Factors (**DF1-DF4**)
                    to determine the **Initial Scope** of the Governance System.
                </p>
                <p class="text-blue-700 mt-2">
                    <strong>Color Legend:</strong>
                </p>
                <ul class="text-blue-700 mt-1 ml-6 list-disc">
                    <li><span class="font-bold text-green-600">Green</span>: Positive score (higher priority)</li>
                    <li><span class="font-bold text-red-600">Red</span>: Negative score (lower priority)</li>
                    <li><span class="font-bold text-yellow-600">Yellow/Neutral</span>: Zero score (baseline priority)
                    </li>
                </ul>
            </div>

            <!-- Success/Error Alerts -->
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

            <!-- Lock Summary Button -->
            @php
                // Check if DF1-DF4 are completed
                $allCompleted = true;
                foreach (['DF1', 'DF2', 'DF3', 'DF4'] as $df) {
                    if (!isset($progress[$df]) || !$progress[$df]['completed']) {
                        $allCompleted = false;
                        break;
                    }
                }
                $isLocked = isset($progress['Summary']) && $progress['Summary']['locked'];
            @endphp

            @if($isLocked)
                <!-- Locked Status -->
                <div class="flex items-center p-6 mb-6 bg-yellow-100 border border-yellow-300 rounded-lg shadow-sm">
                    <svg class="w-6 h-6 mr-3 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <span class="text-yellow-800 font-bold text-lg">🔒 Summary sudah disimpan dan Design Factors DF1-DF4
                            terkunci</span>
                        <p class="text-yellow-700 text-sm mt-1">Design Factors DF1-DF4 tidak dapat diubah lagi. DF5 masih
                            dapat diakses dan diedit.</p>
                    </div>
                </div>
            @elseif($allCompleted)
                <!-- Save Summary Form -->
                <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm mb-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-3">💾 Simpan Summary</h3>
                    <p class="text-gray-600 mb-4">
                        Design Factors DF1-DF4 sudah selesai diisi. Klik tombol di bawah untuk menyimpan Summary dan
                        mengunci DF1-DF4.
                    </p>
                    <div class="bg-yellow-50 border border-yellow-300 rounded-lg p-4 mb-4">
                        <p class="text-yellow-800 font-semibold">⚠️ Peringatan:</p>
                        <p class="text-yellow-700 text-sm mt-1">
                            Setelah Summary disimpan, <strong>Design Factors DF1-DF4 akan terkunci secara
                                permanen</strong> dan tidak dapat diubah lagi. DF5 akan tetap dapat diakses dan diedit.
                            Pastikan data DF1-DF4 sudah benar sebelum
                            melanjutkan.
                        </p>
                    </div>
                    <form id="lockSummaryForm" action="{{ route('design-factors.lock-summary') }}" method="POST">
                        @csrf
                        <button type="button" onclick="confirmLockSummary()"
                            class="flex items-center px-8 py-3 text-base font-bold text-white bg-green-600 rounded-xl hover:bg-green-700 transform hover:scale-105 transition-all shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                                </path>
                            </svg>
                            Simpan Summary & Kunci DF1-DF4
                        </button>
                    </form>

                    <script>
                        function confirmLockSummary() {
                            Swal.fire({
                                title: '🔒 Konfirmasi Penguncian',
                                icon: 'warning',
                                html: `
                                            <div style="text-align: left; margin-top: 10px;">
                                                <p style="color: #4b5563; font-size: 15px; margin-bottom: 15px;">
                                                    Apakah Anda yakin ingin menyimpan Summary dan mengunci <strong>DF1-DF4</strong>?
                                                </p>
                                                <div style="background: #fffbe6; border: 1px solid #ffe58f; padding: 12px; border-radius: 8px;">
                                                    <p style="margin: 0; font-weight: 700; color: #856404; font-size: 14px;">⚠️ Perhatian:</p>
                                                    <ul style="margin: 8px 0 0 15px; padding: 0; color: #856404; font-size: 13px; line-height: 1.5;">
                                                        <li>Data <strong>DF1-DF4</strong> akan terkunci permanen</li>
                                                        <li>Anda tidak dapat mengubah data ini lagi</li>
                                                        <li><strong>DF5</strong> akan tetap dapat diakses</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        `,
                                showCancelButton: true,
                                confirmButtonColor: '#16a34a',
                                cancelButtonColor: '#6b7280',
                                confirmButtonText: '✓ Ya, Simpan & Kunci',
                                cancelButtonText: '✕ Batal',
                                reverseButtons: true,
                                width: '480px',
                                customClass: {
                                    popup: 'rounded-xl shadow-xl'
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Show loading indicator
                                    Swal.fire({
                                        title: 'Menyimpan...',
                                        text: 'Sedang memproses penguncian data',
                                        allowOutsideClick: false,
                                        didOpen: () => {
                                            Swal.showLoading();
                                        }
                                    });
                                    document.getElementById('lockSummaryForm').submit();
                                }
                            });
                        }
                    </script>
                </div>
            @else
                <!-- Warning: Not all DFs completed -->
                <div class="flex items-center p-6 mb-6 bg-orange-100 border border-orange-300 rounded-lg shadow-sm">
                    <svg class="w-6 h-6 mr-3 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <span class="text-orange-800 font-bold">⚠️ Belum semua Design Factors selesai</span>
                        <p class="text-orange-700 text-sm mt-1">Anda harus menyelesaikan Design Factors DF1-DF4
                            terlebih dahulu sebelum dapat menyimpan Summary.</p>
                    </div>
                </div>
            @endif

            {{-- Continue to DF5 Button --}}
            @if($allCompleted)
                <div class="p-6 bg-blue-50 border border-blue-200 rounded-xl shadow-sm mb-6">
                    <h3 class="text-lg font-bold text-blue-800 mb-2">📊 Lanjutkan ke DF5</h3>
                    <p class="text-blue-700 mb-4">
                        Setelah melihat Summary, Anda dapat melanjutkan ke <strong>DF5: Governance and Management
                            Objectives</strong> untuk analisis tambahan.
                    </p>
                    @if(!$isLocked)
                        {{-- Button disabled when NOT locked --}}
                        <button disabled
                            class="inline-flex items-center px-8 py-3 text-base font-bold text-gray-500 bg-gray-300 rounded-xl cursor-not-allowed opacity-60">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                            Kunci Summary Terlebih Dahulu
                        </button>
                        <p class="text-gray-600 text-sm mt-2">
                            Anda harus mengunci Summary (DF1-DF4) terlebih dahulu sebelum dapat melanjutkan ke DF5.
                        </p>
                    @else
                        {{-- Button enabled when locked --}}
                        <a href="{{ route('design-factors.index', 'DF5') }}"
                            class="inline-flex items-center px-8 py-3 text-base font-bold text-white bg-blue-600 rounded-xl hover:bg-blue-700 transform hover:scale-105 transition-all shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6">
                                </path>
                            </svg>
                            Lanjut ke DF5
                        </a>
                    @endif
                </div>
            @endif

        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const summaryData = @json($summaryData);

                // Prepare data for chart
                const labels = summaryData.map(item => item.code);
                const data = summaryData.map(item => item.initial_scope);

                // Create background colors based on value
                const backgroundColors = data.map(value => {
                    if (value >= 0) {
                        return 'rgba(128, 128, 128, 0.7)'; // Gray for positive
                    } else {
                        return 'rgba(192, 0, 0, 0.7)'; // Red for negative
                    }
                });

                const ctx = document.getElementById('summaryChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Initial Scope',
                            data: data,
                            backgroundColor: backgroundColors,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function (context) {
                                        const item = summaryData[context.dataIndex];
                                        return [
                                            `${item.code}: ${item.name}`,
                                            `Initial Scope: ${context.parsed.x}`
                                        ];
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                min: -100,
                                max: 100,
                                grid: {
                                    color: '#e5e7eb'
                                },
                                ticks: {
                                    stepSize: 20,
                                    font: {
                                        size: 11
                                    }
                                }
                            },
                            y: {
                                grid: {
                                    display: true,
                                    borderDash: [5, 5],
                                    color: '#e5e7eb'
                                },
                                ticks: {
                                    font: {
                                        weight: 'bold',
                                        size: 11
                                    },
                                    autoSkip: false
                                }
                            }
                        }
                    },
                    plugins: [{
                        afterDatasetsDraw: function (chart) {
                            const ctx = chart.ctx;
                            chart.data.datasets.forEach(function (dataset, i) {
                                const meta = chart.getDatasetMeta(i);
                                meta.data.forEach(function (bar, index) {
                                    const data = dataset.data[index];
                                    if (data !== 0) {
                                        ctx.fillStyle = '#000';
                                        ctx.font = 'bold 11px Arial';
                                        ctx.textAlign = data >= 0 ? 'left' : 'right';
                                        ctx.textBaseline = 'middle';

                                        const x = data >= 0 ? bar.x + 5 : bar.x - 5;
                                        const y = bar.y;

                                        ctx.fillText(Math.abs(data), x, y);
                                    }
                                });
                            });
                        }
                    }]
                });
            });
        </script>
    @endpush
</x-app-layout>