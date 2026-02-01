<x-app-layout>
    <!-- Chart.js CDN -->
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

        /* Strategic Table Styling (like Excel) */
        .strategic-table {
            border-collapse: collapse;
            width: 100%;
        }

        .strategic-table th {
            background: #4a5d23;
            color: white;
            font-weight: 600;
            padding: 12px 16px;
            text-align: center;
            border: 1px solid #3d4d1c;
        }

        .strategic-table th:first-child {
            text-align: left;
        }

        .strategic-table td {
            padding: 12px 16px;
            border: 1px solid #c5d9a4;
        }

        .strategic-table tr:nth-child(odd) td {
            background: #f0f7e6;
        }

        .strategic-table tr:nth-child(even) td {
            background: white;
        }

        .strategic-table td:first-child {
            text-align: left;
            font-weight: 500;
            color: #1e293b;
        }

        .strategic-table td:not(:first-child) {
            text-align: center;
            font-weight: 600;
        }

        .strategic-table .baseline-col {
            background: #e8f5d6 !important;
            color: #4a5d23;
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

        /* Clean Table - Excel Style for DF3 */
        .clean-table {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #1e2f13;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .clean-table th {
            background-color: #375623 !important;
            color: #ffffff !important;
            font-weight: 700;
            padding: 12px 8px;
            text-align: center;
            border: 0.5px solid #1e2f13;
            font-size: 0.95rem;
            vertical-align: middle;
        }

        .clean-table th:first-child {
            text-align: left;
            padding-left: 16px;
        }

        .clean-table td {
            padding: 8px 12px;
            border: 0.5px solid #1e2f13;
            text-align: center;
            background-color: #e2efda;
            color: #000;
            font-size: 0.95rem;
        }

        .clean-table td:first-child {
            text-align: left;
            padding-left: 16px;
            font-weight: 500;
        }

        .clean-table td.df3-baseline {
            color: #ffffff !important;
            font-style: italic;
            font-weight: 700;
        }

        /* Heatmap Colors for DF3 */
        .bg-val-1 {
            background-color: #548235 !important;
            color: #ffffff !important;
        }

        .bg-val-2 {
            background-color: #a9d08e !important;
            color: #000000 !important;
        }

        .bg-val-3 {
            background-color: #ffff00 !important;
            color: #000000 !important;
        }

        .bg-val-4 {
            background-color: #f4b084 !important;
            color: #000000 !important;
        }

        .bg-val-5 {
            background-color: #ff0000 !important;
            color: #ffffff !important;
        }

        .heat-input {
            background-color: transparent !important;
            border: none !important;
            color: inherit !important;
            width: 100% !important;
            height: 100% !important;
            cursor: pointer;
            text-align: center;
            font-weight: bold;
        }

        /* DF4 Icon Selector Styles */
        .importance-icon-radio {
            appearance: none;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 2px solid #000;
            cursor: pointer;
            position: relative;
            margin: 0 auto;
            display: block;
        }

        .importance-icon-radio.green {
            background-color: #70ad47;
        }

        .importance-icon-radio.yellow {
            background-color: #ffc000;
        }

        .importance-icon-radio.red {
            background-color: #c00000;
        }

        .importance-icon-radio:checked::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #000;
        }

        .df4-importance-cell {
            text-align: center;
            padding: 8px 4px;
        }
    </style>

    <div class="min-h-screen py-8 bg-gray-100">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">

            <!-- Page Header -->
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-gray-800">Kalkulator COBIT Relative Importance</h1>
                <p class="mt-2 text-gray-600">Tailoring Governance System based on Design Factors</p>
            </div>

            <!-- Progress Bar -->
            @php
                $completedCount = 0;
                foreach(['DF1', 'DF2', 'DF3', 'DF4', 'DF5'] as $df) {
                    if(isset($progress[$df]) && $progress[$df]['completed']) {
                        $completedCount++;
                    }
                }
                $progressPercent = ($completedCount / 6) * 100; // 6 steps including Summary
            @endphp
            <div class="mb-6 bg-white rounded-xl shadow-sm p-4">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-semibold text-gray-700">Progress Keseluruhan</span>
                    <span class="text-sm font-bold text-green-600">{{ number_format($progressPercent, 0) }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="bg-green-600 h-3 rounded-full transition-all duration-500" style="width: {{ $progressPercent }}%"></div>
                </div>
            </div>

            <!-- Design Factor Tabs -->
            <div class="flex flex-wrap justify-center gap-2 mb-8">
                @php
                    $tabs = [
                        'DF1' => 'DF1: Enterprise Strategy',
                        'DF2' => 'DF2: Enterprise Goals',
                        'DF3' => 'DF3: Risk Profile',
                        'DF4' => 'DF4: IT-Related Issues',
                    ];
                @endphp

                @foreach($tabs as $tabType => $tabLabel)
                    @php
                        $isActive = $type === $tabType;
                        $isAccessible = isset($progress[$tabType]) && $progress[$tabType]['accessible'];
                        $isCompleted = isset($progress[$tabType]) && $progress[$tabType]['completed'];
                    @endphp
                    <a href="{{ $isAccessible ? route('design-factors.index', $tabType) : '#' }}"
                        class="px-6 py-2 text-sm font-bold rounded-full transition-all inline-flex items-center gap-2
                            {{ $isActive ? 'bg-green-600 text-white shadow-lg' : ($isAccessible ? 'bg-white text-gray-600 hover:bg-gray-200' : 'bg-gray-300 text-gray-500 cursor-not-allowed opacity-60') }}"
                        {{ !$isAccessible ? 'onclick="return false;"' : '' }}>
                        {{ $tabLabel }}
                        @if($isCompleted)
                            <span class="text-lg">✅</span>
                        @endif
                    </a>
                @endforeach

                {{-- Summary Tab --}}
                <a href="{{ isset($progress['Summary']) && $progress['Summary']['accessible'] ? route('design-factors.summary') : '#' }}"
                    class="px-6 py-2 text-sm font-bold rounded-full transition-all
                        {{ isset($progress['Summary']) && $progress['Summary']['accessible'] ? 'bg-white text-gray-600 hover:bg-gray-200' : 'bg-gray-300 text-gray-500 cursor-not-allowed opacity-60' }}"
                    {{ !(isset($progress['Summary']) && $progress['Summary']['accessible']) ? 'onclick="return false;"' : '' }}>
                    Summary
                </a>

                {{-- DF5 Tab --}}
                @php
                    $df5Active = $type === 'DF5';
                    $df5Accessible = isset($progress['DF5']) && $progress['DF5']['accessible'];
                    $df5Completed = isset($progress['DF5']) && $progress['DF5']['completed'];
                @endphp
                <a href="{{ $df5Accessible ? route('design-factors.index', 'DF5') : '#' }}"
                    class="px-6 py-2 text-sm font-bold rounded-full transition-all inline-flex items-center gap-2
                        {{ $df5Active ? 'bg-green-600 text-white shadow-lg' : ($df5Accessible ? 'bg-white text-gray-600 hover:bg-gray-200' : 'bg-gray-300 text-gray-500 cursor-not-allowed opacity-60') }}"
                    {{ !$df5Accessible ? 'onclick="return false;"' : '' }}>
                    DF5: Governance Objectives
                    @if($df5Completed)
                        <span class="text-lg">✅</span>
                    @endif
                </a>
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

            <!-- Lock Warning Banner -->
            @if(isset($designFactor) && $designFactor->is_locked)
                <div class="flex items-center p-4 mb-6 bg-yellow-100 border border-yellow-300 rounded-lg shadow-sm">
                    <svg class="w-5 h-5 mr-3 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-yellow-800 font-semibold">🔒 Design Factor ini sudah terkunci dan tidak dapat diubah.</span>
                </div>
            @endif

            <form id="designFactorForm" action="{{ route('design-factors.store') }}" method="POST">
                @csrf
                <input type="hidden" name="factor_type" value="{{ $type }}">

                <!-- Section 1: Inputs Table -->
                <div class="mb-6 overflow-hidden light-card rounded-xl">
                    <div class="p-4 border-b border-gray-200 bg-slate-50">
                        <h2 class="text-xl font-bold text-green-600">
                            @if($type === 'DF1')
                                Strategic Objectives
                            @elseif($type === 'DF2')
                                Enterprise Goals
                            @elseif($type === 'DF3')
                                Risk Scenario Categories
                            @elseif($type === 'DF4')
                                IT-Related Issues
                            @elseif($type === 'DF5')
                                Governance and Management Objectives Importance
                            @endif
                        </h2>
                    </div>
                    <div class="p-4 bg-white">
                            @if($type === 'DF5')
                                <div class="w-full overflow-x-auto">
                                    <table class="strategic-table">
                                        <thead>
                                            <tr>
                                                <th style="min-width: 350px;">Governance/Management Objectives</th>
                                                <th style="min-width: 150px;">Importance (%)</th>
                                                <th style="min-width: 150px;">Baseline (%)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Set of Governance and Management Objectives (High)</td>
                                                <td class="importance-cell">
                                                    <input type="number" name="importance_high" id="importance_high"
                                                        value="{{ $df5->importance_high ?? 50 }}" min="0" max="100"
                                                        step="0.01"
                                                        class="w-24 px-2 py-1 text-center font-extrabold bg-white border border-gray-300 rounded focus:outline-none focus:border-green-500 df5-input"
                                                        {{ (isset($df5) && method_exists($df5, 'is_locked') && $df5->is_locked) ? 'disabled readonly' : '' }}>
                                                </td>
                                                <td class="baseline-col text-center font-bold">33%</td>
                                            </tr>
                                            <tr>
                                                <td>Set of Governance and Management Objectives (Normal)</td>
                                                <td class="importance-cell">
                                                    <input type="number" name="importance_normal" id="importance_normal"
                                                        value="{{ $df5->importance_normal ?? 50 }}" min="0" max="100"
                                                        step="0.01"
                                                        class="w-24 px-2 py-1 text-center font-extrabold bg-white border border-gray-300 rounded focus:outline-none focus:border-green-500 df5-input"
                                                        {{ (isset($df5) && method_exists($df5, 'is_locked') && $df5->is_locked) ? 'disabled readonly' : '' }}>
                                                </td>
                                                <td class="baseline-col text-center font-bold">67%</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr class="bg-gray-100 font-bold">
                                                <td class="text-right pr-4">Total Importance:</td>
                                                <td class="text-center">
                                                    <span id="totalPercentageDisplay" class="text-lg">100%</span>
                                                </td>
                                                <td class="text-center">100%</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            @else
                                <!-- Table container -->
                                <div class="lg:col-span-9 xl:col-span-10 overflow-x-auto min-w-0">
                                    <table
                                        class="{{ in_array($type, ['DF1', 'DF2']) ? 'strategic-table' : 'clean-table' }}">
                                        <thead>
                                            <tr>
                                                @if($type === 'DF3')
                                                    <th style="min-width: 400px;">Risk Scenario Category</th>
                                                    <th style="min-width: 100px;">Impact<br>(1-5)</th>
                                                    <th style="min-width: 100px;">Likelihood<br>(1-5)</th>
                                                    <th style="min-width: 100px;">Risk Rating</th>
                                                @elseif($type === 'DF4')
                                                    <th style="min-width: 500px;">IT-Related Issue</th>
                                                    <th style="min-width: 150px;">Importance</th>
                                                @else
                                                    <th style="min-width: 350px;">Value</th>
                                                    <th style="min-width: 150px;">Importance (1-5)</th>
                                                @endif
                                                <th style="min-width: 100px;">Baseline</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($metadata as $key => $data)
                                                <tr>
                                                    <td class="font-medium text-gray-700">{{ $data['name'] }}</td>
    
                                                    @if($type === 'DF3')
                                                        <td class="p-0">
                                                            <input type="number" name="inputs[{{ $key }}][impact]"
                                                                value="{{ data_get($designFactor->inputs, $key . '.impact', 3) }}"
                                                                min="1" max="5" class="heat-input df3-input impact-input"
                                                                data-key="{{ $key }}"
                                                                {{ $designFactor->is_locked ? 'disabled readonly' : '' }}>
                                                        </td>
                                                        <td class="p-0">
                                                            <input type="number" name="inputs[{{ $key }}][likelihood]"
                                                                value="{{ data_get($designFactor->inputs, $key . '.likelihood', 3) }}"
                                                                min="1" max="5" class="heat-input df3-input likelihood-input"
                                                                data-key="{{ $key }}"
                                                                {{ $designFactor->is_locked ? 'disabled readonly' : '' }}>
                                                        </td>
                                                        <td class="bg-white p-0">
                                                            <div class="flex items-center justify-center p-2">
                                                                <div class="w-4 h-4 rounded-full risk-dot shadow-sm"
                                                                    data-key="{{ $key }}"></div>
                                                            </div>
                                                        </td>
                                                    @elseif($type === 'DF4')
                                                        <td class="df4-importance-cell">
                                                            <div class="flex justify-center gap-3">
                                                                @php
                                                                    $currentImportance = data_get($designFactor->inputs, $key . '.importance', 1);
                                                                @endphp
                                                                <label class="flex flex-col items-center cursor-pointer">
                                                                    <input type="radio" 
                                                                        name="inputs[{{ $key }}][importance]" 
                                                                        value="1"
                                                                        class="importance-icon-radio green importance-input"
                                                                        data-key="{{ $key }}"
                                                                        {{ $currentImportance == 1 ? 'checked' : '' }}
                                                                        {{ $designFactor->is_locked ? 'disabled' : '' }}>
                                                                </label>
                                                                <label class="flex flex-col items-center cursor-pointer">
                                                                    <input type="radio" 
                                                                        name="inputs[{{ $key }}][importance]" 
                                                                        value="2"
                                                                        class="importance-icon-radio yellow importance-input"
                                                                        data-key="{{ $key }}"
                                                                        {{ $currentImportance == 2 ? 'checked' : '' }}
                                                                        {{ $designFactor->is_locked ? 'disabled' : '' }}>
                                                                </label>
                                                                <label class="flex flex-col items-center cursor-pointer">
                                                                    <input type="radio" 
                                                                        name="inputs[{{ $key }}][importance]" 
                                                                        value="3"
                                                                        class="importance-icon-radio red importance-input"
                                                                        data-key="{{ $key }}"
                                                                        {{ $currentImportance == 3 ? 'checked' : '' }}
                                                                        {{ $designFactor->is_locked ? 'disabled' : '' }}>
                                                                </label>
                                                            </div>
                                                        </td>
                                                    @else
                                                        <td class="importance-cell">
                                                            <input type="number" name="inputs[{{ $key }}][importance]"
                                                                value="{{ data_get($designFactor->inputs, $key . '.importance', 3) }}"
                                                                min="1" max="5"
                                                                class="w-16 px-2 py-1 text-center font-extrabold bg-white border border-gray-300 rounded focus:outline-none focus:border-green-500 importance-input"
                                                                data-key="{{ $key }}"
                                                                {{ $designFactor->is_locked ? 'disabled readonly' : '' }}>
                                                        </td>
                                                    @endif
    
                                                    <td class="{{ $type === 'DF3' ? 'df3-baseline' : 'baseline-col' }}">
                                                        @php
                                                            $baselineDefault = 3;
                                                            if ($type === 'DF3') {
                                                                $baselineDefault = 9;
                                                            } elseif ($type === 'DF4') {
                                                                $baselineDefault = 2;
                                                            }
                                                        @endphp
                                                        {{ data_get($designFactor->inputs, $key . '.baseline', $baselineDefault) }}
                                                        <input type="hidden" name="inputs[{{ $key }}][baseline]"
                                                            value="{{ data_get($designFactor->inputs, $key . '.baseline', $baselineDefault) }}"
                                                            class="baseline-input">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif

                            @if($type === 'DF3')
                                <!-- Legend container -->
                                <div class="w-full lg:col-span-3 xl:col-span-2">
                                    <div class="border border-gray-400 overflow-hidden shadow-sm">
                                        <div class="bg-white p-2 border-b border-gray-400 flex items-center gap-3">
                                            <div class="w-4 h-4 rounded-full"
                                                style="background-color: #c00000; border: 1px solid #000;"></div>
                                            <span class="text-xs font-bold text-gray-800">Very High Risk</span>
                                        </div>
                                        <div class="bg-white p-2 border-b border-gray-400 flex items-center gap-3">
                                            <div class="w-4 h-4 rounded-full"
                                                style="background-color: #edbd70; border: 1px solid #000;"></div>
                                            <span class="text-xs font-bold text-gray-800">High Risk</span>
                                        </div>
                                        <div class="bg-white p-2 border-b border-gray-400 flex items-center gap-3">
                                            <div class="w-4 h-4 rounded-full"
                                                style="background-color: #72a488; border: 1px solid #000;"></div>
                                            <span class="text-xs font-bold text-gray-800">Normal Risk</span>
                                        </div>
                                        <div class="bg-white p-2 flex items-center gap-3">
                                            <div class="w-4 h-4 rounded-full"
                                                style="background-color: #4b4b4b; border: 1px solid #000;"></div>
                                            <span class="text-xs font-bold text-gray-800">Low Risk</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            @if($type === 'DF4')
                                <!-- Legend container for DF4 -->
                                <div class="w-full lg:col-span-3 xl:col-span-2">
                                    <div class="border border-gray-400 overflow-hidden shadow-sm">
                                        <div class="bg-white p-3 border-b border-gray-400 flex items-center gap-3">
                                            <div class="w-5 h-5 rounded-full"
                                                style="background-color: #70ad47; border: 2px solid #000;"></div>
                                            <span class="text-sm font-bold text-gray-800">No Issue</span>
                                        </div>
                                        <div class="bg-white p-3 border-b border-gray-400 flex items-center gap-3">
                                            <div class="w-5 h-5 rounded-full"
                                                style="background-color: #ffc000; border: 2px solid #000;"></div>
                                            <span class="text-sm font-bold text-gray-800">Issue</span>
                                        </div>
                                        <div class="bg-white p-3 flex items-center gap-3">
                                            <div class="w-5 h-5 rounded-full"
                                                style="background-color: #c00000; border: 2px solid #000;"></div>
                                            <span class="text-sm font-bold text-gray-800">Serious Issue</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Section 2: Calculated Values (Hidden for all DFs) -->
                <div class="hidden">
                    <span id="avgImpDisplay"></span>
                    <span id="weightDisplay"></span>
                </div>


                <!-- Section 3: Governance Outcomes -->
                <div class="mb-6 overflow-hidden light-card rounded-xl shadow-sm">
                    <div class="p-4 border-b border-gray-200 bg-slate-50">
                        <h2 class="text-xl font-bold text-green-600">Tailored Governance System</h2>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="clean-table">
                            <thead>
                                <tr>
                                    <th>Objective Code</th>
                                    <th>Score</th>
                                    <th>Baseline Score</th>
                                    <th>Relative Importance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($type === 'DF5')
                                    @foreach($results as $index => $result)
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
                                            </td>
                                            <td class="font-bold text-gray-700 item-score-display">
                                                {{ number_format($result['score'] / 100, 2) }}
                                            </td>
                                            <td class="font-bold text-gray-700 item-baseline-display">
                                                {{ number_format($result['baseline_score'] / 100, 2) }}
                                            </td>
                                            <td>
                                                <span class="relative-importance font-black text-lg
                                                    @if($result['relative_importance'] > 0) value-positive
                                                    @elseif($result['relative_importance'] < 0) value-negative
                                                    @else value-neutral
                                                    @endif"
                                                    data-index="{{ $index }}">
                                                    {{ $result['relative_importance'] > 0 ? '+' : '' }}{{ (int) $result['relative_importance'] }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    @foreach($designFactor->items as $index => $item)
                                        <tr>
                                            <td>
                                                <span
                                                    class="px-3 py-1 text-sm font-black rounded
                                                                                                                        @if(str_starts_with($item->code, 'EDM')) badge-edm
                                                                                                                        @elseif(str_starts_with($item->code, 'APO')) badge-apo
                                                                                                                        @elseif(str_starts_with($item->code, 'BAI')) badge-bai
                                                                                                                        @elseif(str_starts_with($item->code, 'DSS')) badge-dss
                                                                                                                        @elseif(str_starts_with($item->code, 'MEA')) badge-mea
                                                                                                                        @endif">
                                                    {{ $item->code }}
                                                </span>
                                                <input type="hidden" name="items[{{ $index }}][code]" value="{{ $item->code }}">
                                                <input type="hidden" name="items[{{ $index }}][score]"
                                                    value="{{ number_format($item->score, 1, '.', '') }}" class="item-score-hidden">
                                                <input type="hidden" name="items[{{ $index }}][baseline_score]"
                                                    value="{{ number_format($item->baseline_score, 1, '.', '') }}" class="item-baseline-hidden">
                                            </td>
                                            <td class="font-bold text-gray-700 item-score-display">{{ $item->score }}
                                            </td>
                                            <td class="font-bold text-gray-700 item-baseline-display">
                                                {{ $item->baseline_score }}
                                            </td>
                                            <td>
                                                <span class="relative-importance font-black text-lg
                                                                                                                        @if($item->relative_importance > 0) value-positive
                                                                                                                        @elseif($item->relative_importance < 0) value-negative
                                                                                                                        @else value-neutral
                                                                                                                        @endif"
                                                    data-index="{{ $index }}">
                                                    {{ $item->relative_importance > 0 ? '+' : '' }}{{ (int) $item->relative_importance }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Section 4: Charts -->
                <div class="grid grid-cols-1 gap-6 mb-8 lg:grid-cols-2">
                    <div class="p-6 bg-white border border-gray-200 shadow-sm rounded-xl">
                        <h3 class="mb-2 text-lg font-bold text-gray-800">{{ $type }} Output</h3>
                        <div class="relative" style="height: {{ $type === 'DF4' ? '1000px' : '700px' }};">
                            <canvas id="barChart"></canvas>
                        </div>
                    </div>

                    <div class="p-6 bg-white border border-gray-200 shadow-sm rounded-xl">
                        <h3 class="mb-2 text-lg font-bold text-gray-800">{{ $type }} Radar</h3>
                        <div class="relative" style="height: {{ $type === 'DF4' ? '1000px' : '700px' }};">
                            <canvas id="radarChart"></canvas>
                        </div>
                    </div>
                </div>


                <!-- Action Button -->
                <div class="flex justify-center gap-4 p-6 bg-slate-50 border border-gray-200 rounded-xl shadow-inner">
                    @if(isset($designFactor) && $designFactor->is_locked)
                        <div class="flex items-center px-10 py-4 text-base font-bold text-gray-600 bg-gray-300 rounded-xl shadow-lg cursor-not-allowed">
                            <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                            </svg>
                            Terkunci
                        </div>
                    @else
                        <button type="submit"
                            class="flex items-center px-10 py-4 text-base font-bold text-white bg-green-600 rounded-xl hover:bg-green-700 transform hover:scale-105 transition-all shadow-lg">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                                </path>
                            </svg>
                            Simpan Analisis {{ $type }}
                        </button>
                        
                        <!-- Reset All Button -->
                        <button type="button" onclick="confirmResetAll()"
                            class="flex items-center px-10 py-4 text-base font-bold text-white bg-red-600 rounded-xl hover:bg-red-700 transform hover:scale-105 transition-all shadow-lg">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                </path>
                            </svg>
                            Reset Semua DF
                        </button>
                    @endif
                </div>
            </form>

            <!-- Hidden form for reset all -->
            <form id="resetAllForm" action="{{ route('design-factors.reset-all') }}" method="POST" style="display: none;">
                @csrf
            </form>

            <script>
                function confirmResetAll() {
                    if (confirm('⚠️ PERINGATAN!\n\nApakah Anda yakin ingin mereset SEMUA Design Factor (DF1, DF2, DF3, DF4)?\n\nSemua data yang telah diisi akan dihapus dan dikembalikan ke nilai default.\n\nTindakan ini TIDAK DAPAT dibatalkan!')) {
                        document.getElementById('resetAllForm').submit();
                    }
                }
            </script>
        </div>
    </div>


    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const factorType = "{{ $type }}";
                const avgImpDisplay = document.getElementById('avgImpDisplay');
                const weightDisplay = document.getElementById('weightDisplay');

                const importanceInputs = document.querySelectorAll('.importance-input');
                const df3Inputs = document.querySelectorAll('.df3-input');
                const baselineInputs = document.querySelectorAll('.baseline-input');

                const itemScores = [];
                const itemBaselines = [];
                document.querySelectorAll('.item-score-hidden').forEach(input => itemScores.push(parseFloat(input.value) || 0));
                document.querySelectorAll('.item-baseline-hidden').forEach(input => itemBaselines.push(parseFloat(input.value) || 0));

                let chartLabels = factorType === 'DF5' 
                    ? @json(isset($results) ? $results->pluck('code') : [])
                    : @json(isset($designFactor) && isset($designFactor->items) ? $designFactor->items->pluck('code') : []);
                let chartData = factorType === 'DF5'
                    ? @json(isset($results) ? $results->pluck('relative_importance') : [])
                    : [];
                let barChart, radarChart;

                function updateRiskDisplays() {
                    if (factorType === 'DF3') {
                        const categories = {};
                        df3Inputs.forEach(input => {
                            const key = input.dataset.key;
                            const val = parseInt(input.value) || 0;

                            // Update cell background
                            const parentTd = input.closest('td');
                            parentTd.classList.remove('bg-val-1', 'bg-val-2', 'bg-val-3', 'bg-val-4', 'bg-val-5', 'importance-cell');
                            if (val >= 1 && val <= 5) parentTd.classList.add(`bg-val-${val}`);
                            else parentTd.classList.add('importance-cell');

                            if (!categories[key]) categories[key] = { impact: 3, likelihood: 3 };
                            if (input.classList.contains('impact-input')) categories[key].impact = parseFloat(input.value) || 3;
                            if (input.classList.contains('likelihood-input')) categories[key].likelihood = parseFloat(input.value) || 3;
                        });

                        for (const key in categories) {
                            const rating = categories[key].impact * categories[key].likelihood;
                            const dot = document.querySelector(`.risk-dot[data-key="${key}"]`);

                        }
                    } else if (factorType === 'DF5') {
                        // Total percentage display for DF5
                        const high = parseFloat(document.getElementById('importance_high').value) || 0;
                        const normal = parseFloat(document.getElementById('importance_normal').value) || 0;
                        const total = high + normal;
                        const display = document.getElementById('totalPercentageDisplay');
                        if (display) {
                            display.innerText = total.toFixed(2) + '%';
                            display.className = Math.abs(total - 100) < 0.01 ? 'text-lg text-green-600' : 'text-lg text-red-600';
                        }
                    }
                }



                function initCharts() {
                    const barCtx = document.getElementById('barChart').getContext('2d');
                    const radarCtx = document.getElementById('radarChart').getContext('2d');

                    barChart = new Chart(barCtx, {
                        type: 'bar',
                        data: {
                            labels: chartLabels,
                            datasets: [{
                                label: 'Relative Importance',
                                data: chartData,
                                backgroundColor: chartData.map(v => v >= 0 ? 'rgba(79, 124, 53, 0.7)' : 'rgba(192, 0, 0, 0.7)'),
                                borderWidth: 1
                            }]
                        },
                        options: {
                            indexAxis: 'y',
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: { legend: { display: false } },
                            scales: {
                                x: { min: -100, max: 100, grid: { color: '#e5e7eb' }, ticks: { stepSize: 25 } },
                                y: { grid: { display: true, borderDash: [5, 5], color: '#e5e7eb' }, ticks: { font: { weight: 'bold' }, autoSkip: false } }
                            }
                        }
                    });

                    radarChart = new Chart(radarCtx, {
                        type: 'radar',
                        data: {
                            labels: chartLabels,
                            datasets: [{
                                label: 'Relative Importance',
                                data: chartData.map(v => v + 100),
                                backgroundColor: 'rgba(79, 124, 53, 0.2)',
                                borderColor: 'rgba(79, 124, 53, 1)',
                                borderWidth: 2,
                                pointBackgroundColor: 'rgba(79, 124, 53, 1)',
                                pointRadius: 2
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: { legend: { display: false } },
                            scales: {
                                r: {
                                    min: 0, max: 200,
                                    ticks: { stepSize: 25, callback: v => v - 100, backdropColor: 'transparent' },
                                    pointLabels: { font: { size: 10, weight: 'bold' } }
                                }
                            }
                        }
                    });
                }

                function updateCharts() {
                    if (!barChart || !radarChart) return;
                    barChart.data.datasets[0].data = chartData;
                    barChart.data.datasets[0].backgroundColor = chartData.map(v => v >= 0 ? 'rgba(79, 124, 53, 0.7)' : 'rgba(192, 0, 0, 0.7)');
                    barChart.update('none');
                    radarChart.data.datasets[0].data = chartData.map(v => v + 100);
                    radarChart.update('none');
                }


                function calculate() {
                    updateRiskDisplays();
                    
                    if (factorType === 'DF5') {
                        autoCalculateDF5();
                        return;
                    }

                    let totalVal = 0;
                    let totalBase = 0;
                    let count = 0;

                    if (factorType === 'DF3') {
                        const grouped = {};
                        df3Inputs.forEach(input => {
                            const key = input.dataset.key;
                            if (!grouped[key]) grouped[key] = { impact: 3, likelihood: 3 };
                            if (input.classList.contains('impact-input')) grouped[key].impact = parseFloat(input.value) || 3;
                            if (input.classList.contains('likelihood-input')) grouped[key].likelihood = parseFloat(input.value) || 3;
                        });
                        for (const k in grouped) {
                            totalVal += grouped[k].impact * grouped[k].likelihood;
                            count++;
                        }
                        baselineInputs.forEach(input => totalBase += parseFloat(input.value) || 9);
                    } else {
                        // For DF4, need to get the checked radio button value for each group
                        if (factorType === 'DF4') {
                            // Get all unique keys from importance inputs
                            const keys = new Set();
                            importanceInputs.forEach(input => {
                                if (input.dataset.key) keys.add(input.dataset.key);
                            });
                            
                            // For each key, get the checked radio button value
                            keys.forEach(key => {
                                const checkedRadio = document.querySelector(`.importance-input[data-key="${key}"]:checked`);
                                if (checkedRadio) {
                                    totalVal += parseFloat(checkedRadio.value) || 1;
                                    count++;
                                }
                            });
                        } else {
                            // For DF1, DF2 - simple input fields
                            importanceInputs.forEach(input => {
                                totalVal += parseFloat(input.value) || 1;
                                count++;
                            });
                        }
                        // DF4 has baseline=2, others have baseline=3
                        const defaultBaseline = (factorType === 'DF4') ? 2 : 3;
                        baselineInputs.forEach(input => totalBase += parseFloat(input.value) || defaultBaseline);
                    }

                    const avgImp = totalVal / count;
                    const avgBase = totalBase / count;

                    let weight = 1.0;
                    if (avgImp > 0 && avgBase > 0) {
                        if (factorType === 'DF1' || factorType === 'DF4') {
                            // DF1 and DF4: Baseline / Importance
                            weight = avgBase / avgImp;
                        } else if (factorType === 'DF2' || factorType === 'DF3') {
                            // DF2, DF3: Importance / Baseline
                            weight = avgImp / avgBase;
                        }
                    }

                    avgImpDisplay.textContent = avgImp.toFixed(2);
                    weightDisplay.textContent = weight.toFixed(6);

                    chartData = [];
                    document.querySelectorAll('.relative-importance').forEach((display, index) => {
                        const score = itemScores[index] || 0;
                        const bScore = itemBaselines[index] || 0;
                        let relImp = 0;
                        if (bScore > 0) {
                            const calculated = (weight * 100 * score) / bScore;

                            if (factorType === 'DF3') {
                                // Formula: IFERROR(MROUND(($G$28*100*B35/C35);5)-100;0)
                                relImp = Math.round(calculated / 5) * 5 - 100;
                            } else {
                                relImp = Math.round(calculated / 5) * 5 - 100;
                            }
                        }
                        chartData.push(relImp);
                        display.textContent = (relImp > 0 ? '+' : '') + Math.round(relImp);
                        display.className = 'relative-importance font-black text-lg ' + (relImp > 0 ? 'value-positive' : (relImp < 0 ? 'value-negative' : 'value-neutral'));
                    });

                    updateCharts();
                }


                function autoCalculateDF5() {
                    const high = parseFloat(document.getElementById('importance_high').value) || 0;
                    const normal = parseFloat(document.getElementById('importance_normal').value) || 0;

                    fetch("{{ route('design-factors.df5.calculate') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({ importance_high: high, importance_normal: normal })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.results) {
                            const resultsArray = Object.values(data.results);
                            chartData = [];
                            
                            resultsArray.forEach((result, index) => {
                                const span = document.querySelector(`.relative-importance[data-index="${index}"]`);
                                if (span) {
                                    const val = Math.round(result.relative_importance);
                                    span.innerText = (val > 0 ? '+' : '') + val;
                                    span.className = 'relative-importance font-black text-lg ' +
                                        (val > 0 ? 'value-positive' : (val < 0 ? 'value-negative' : 'value-neutral'));
                                    
                                    const row = span.closest('tr');
                                    if (row) {
                                        const scoreCell = row.querySelector('.item-score-display');
                                        const baselineCell = row.querySelector('.item-baseline-display');
                                        if (scoreCell) scoreCell.innerText = (result.score / 100).toFixed(2);
                                        if (baselineCell) baselineCell.innerText = (result.baseline_score / 100).toFixed(2);
                                    }
                                }
                                chartData.push(result.relative_importance);
                            });
                            updateCharts();
                        }
                    })
                    .catch(error => console.error('Error calculating DF5:', error));
                }

                importanceInputs.forEach(input => {
                    input.addEventListener('input', calculate);
                    input.addEventListener('change', calculate);
                });
                df3Inputs.forEach(input => input.addEventListener('input', calculate));
                document.querySelectorAll('.df5-input').forEach(input => input.addEventListener('input', calculate));

                initCharts();
                if (factorType === 'DF5') {
                    updateCharts();
                } else {
                    calculate();
                }


            });
        </script>
    @endpush
</x-app-layout>