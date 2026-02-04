<x-app-layout>
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                <h1 class="text-3xl font-bold text-gray-800">Kalkulator COBIT Relative Importance</h1>
                <p class="mt-2 text-gray-600">Tailoring Governance System based on Design Factors</p>
            </div>

            <!-- Design Factor Tabs -->
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
                    <a href="{{ $isAccessible ? route('design-factors.index', $tabType) : '#' }}"
                        class="px-6 py-2 text-sm font-bold rounded-full transition-all inline-flex items-center gap-2
                                                                                                                                                                                                                                                                                                        {{ $type === $tabType ? 'bg-green-600 text-white shadow-lg' : ($isAccessible ? 'bg-white text-gray-600 hover:bg-gray-200' : 'bg-gray-300 text-gray-500 cursor-not-allowed opacity-60') }}"
                        {{ !$isAccessible ? 'onclick="return false;"' : '' }}>
                        {{ $tabLabel }}
                        @if($isCompleted)
                            <span class="text-lg">✅</span>
                        @endif
                    </a>
                @endforeach

                {{-- Summary Tab --}}
                @php
                    $summaryAccessible = isset($progress['Summary']) && $progress['Summary']['accessible'];
                    $summaryLocked = isset($progress['Summary']) && $progress['Summary']['locked'];
                @endphp
                <a href="{{ $summaryAccessible ? route('design-factors.summary') : '#' }}"
                    class="px-6 py-2 text-sm font-bold rounded-full transition-all inline-flex items-center gap-2
                    {{ $summaryAccessible ? 'bg-white text-gray-600 hover:bg-gray-200' : 'bg-gray-300 text-gray-500 cursor-not-allowed opacity-60' }}" {{ !$summaryAccessible ? 'onclick="return false;"' : '' }}>
                    Summary
                    @if($summaryLocked)
                        <span class="text-lg">🔒</span>
                    @endif
                </a>

                {{-- DF5 Tab --}}
                @php
                    $df5Accessible = isset($progress['DF5']) && $progress['DF5']['accessible'];
                    $df5Completed = isset($progress['DF5']) && $progress['DF5']['completed'];
                @endphp
                <a href="{{ $df5Accessible ? route('design-factors.index', 'DF5') : '#' }}"
                    class="px-6 py-2 text-sm font-bold rounded-full transition-all inline-flex items-center gap-2
                    {{ $type === 'DF5' ? 'bg-green-600 text-white shadow-lg' : ($df5Accessible ? 'bg-white text-gray-600 hover:bg-gray-200' : 'bg-gray-300 text-gray-500 cursor-not-allowed opacity-60') }}"
                    {{ !$df5Accessible ? 'onclick="return false;"' : '' }}>
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
                    @php
                        // For DF6-DF10, we'll assume they are accessible if DF5 is accessible for now
                        // Or just show them as normal tabs if the user wants them visible
                    @endphp
                    <a href="{{ route('design-factors.index', $tabType) }}"
                        class="px-6 py-2 text-sm font-bold rounded-full transition-all {{ $type === $tabType ? 'bg-green-600 text-white shadow-lg' : 'bg-white text-gray-600 hover:bg-gray-200' }}">
                        {{ $tabLabel }}
                    </a>
                @endforeach
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

            <form id="designFactorForm" action="{{ route('design-factors.store') }}" method="POST">
                @csrf
                <input type="hidden" name="factor_type" value="{{ $type }}">

                <!-- Section 1: Inputs Table -->
                <div class="mb-6 overflow-hidden light-card rounded-xl">
                    <div class="p-4 border-b border-gray-200 bg-slate-50">
                        <h2 class="text-xl font-bold text-green-600">
                            {{ $factorInfo['title'] }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">{{ $factorInfo['description'] }}</p>
                    </div>
                    <div class="p-4 bg-white">
                        @if($type === 'DF5')
                            <!-- DF5 Input Table -->
                            <div id="smartMessageBoxMain" class="mb-4 p-3 rounded-lg border hidden">
                                <div class="flex items-center">
                                    <div id="smartMessageIconMain" class="mr-3"></div>
                                    <div id="smartMessageContentMain" class="text-sm font-medium"></div>
                                </div>
                            </div>
                            <div class="w-full overflow-x-auto">
                                <table class="strategic-table">
                                    <thead>
                                        <tr>
                                            <th>Value</th>
                                            <th>Importance (100%)</th>
                                            <th>Baseline</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Set of Governance and Management Objectives (High)</td>
                                            <td class="importance-cell text-center">
                                                <input type="number" name="importance_high" id="importance_high"
                                                    value="{{ $df5->importance_high ?? 50 }}" min="0" max="100" step="0.01"
                                                    class="w-24 px-2 py-1 text-center font-extrabold bg-white border border-gray-300 rounded focus:outline-none focus:border-green-500 df5-input"
                                                    {{ (isset($df5) && method_exists($df5, 'is_locked') && $df5->is_locked) ? 'disabled readonly' : '' }}>
                                                <span class="ml-1">%</span>
                                            </td>
                                            <td class="baseline-col text-center font-bold">33%</td>
                                        </tr>
                                        <tr>
                                            <td>Set of Governance and Management Objectives (Normal)</td>
                                            <td class="importance-cell text-center">
                                                <input type="number" name="importance_normal" id="importance_normal"
                                                    value="{{ $df5->importance_normal ?? 50 }}" min="0" max="100"
                                                    step="0.01"
                                                    class="w-24 px-2 py-1 text-center font-extrabold bg-white border border-gray-300 rounded focus:outline-none focus:border-green-500 df5-input"
                                                    {{ (isset($df5) && method_exists($df5, 'is_locked') && $df5->is_locked) ? 'disabled readonly' : '' }}>
                                                <span class="ml-1">%</span>
                                            </td>
                                            <td class="baseline-col text-center font-bold">67%</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-gray-100 font-bold">
                                            <td class="text-right pr-4">Total Importance:</td>
                                            <td class="text-center">
                                                <span id="totalPercentageDisplay" class="text-lg">100%</span>
                                                <span id="validationMessage" class="ml-2"></span>
                                            </td>
                                            <td class="text-center">100%</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @elseif($type === 'DF8')
                            <!-- DF8 Input Table -->
                            <div id="smartMessageBoxDF8" class="mb-4 p-3 rounded-lg border hidden">
                                <div class="flex items-center">
                                    <div id="smartMessageIconDF8" class="mr-3"></div>
                                    <div id="smartMessageContentDF8" class="text-sm font-medium"></div>
                                </div>
                            </div>
                            <div class="w-full overflow-x-auto">
                                <table class="strategic-table">
                                    <thead>
                                        <tr>
                                            <th>Value</th>
                                            <th>Importance (100%)</th>
                                            <th>Baseline</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Outsourcing</td>
                                            <td class="importance-cell text-center">
                                                <input type="number" name="importance_outsourcing"
                                                    id="importance_outsourcing" data-key="outsourcing"
                                                    value="{{ $df8->importance_outsourcing ?? 33.00 }}" min="0" max="100"
                                                    step="0.01"
                                                    class="w-24 px-2 py-1 text-center font-extrabold bg-white border border-gray-300 rounded focus:outline-none focus:border-green-500 df8-input importance-input">
                                                <span class="ml-1">%</span>
                                            </td>
                                            <td class="baseline-col text-center font-bold">33%</td>
                                        </tr>
                                        <tr>
                                            <td>Cloud</td>
                                            <td class="importance-cell text-center">
                                                <input type="number" name="importance_cloud" id="importance_cloud"
                                                    data-key="cloud" value="{{ $df8->importance_cloud ?? 33.00 }}" min="0"
                                                    max="100" step="0.01"
                                                    class="w-24 px-2 py-1 text-center font-extrabold bg-white border border-gray-300 rounded focus:outline-none focus:border-green-500 df8-input importance-input">
                                                <span class="ml-1">%</span>
                                            </td>
                                            <td class="baseline-col text-center font-bold">33%</td>
                                        </tr>
                                        <tr>
                                            <td>Insourced</td>
                                            <td class="importance-cell text-center">
                                                <input type="number" name="importance_insourced" id="importance_insourced"
                                                    data-key="insourced" value="{{ $df8->importance_insourced ?? 34.00 }}"
                                                    min="0" max="100" step="0.01"
                                                    class="w-24 px-2 py-1 text-center font-extrabold bg-white border border-gray-300 rounded focus:outline-none focus:border-green-500 df8-input importance-input">
                                                <span class="ml-1">%</span>
                                            </td>
                                            <td class="baseline-col text-center font-bold">34%</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-gray-100 font-bold">
                                            <td class="text-right pr-4">Total Importance:</td>
                                            <td class="text-center">
                                                <span id="totalPercentageDisplay" class="text-lg">100%</span>
                                                <span id="validationMessage" class="ml-2"></span>
                                            </td>
                                            <td class="text-center">100%</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @elseif($type === 'DF6')
                            <!-- DF6 Input Table -->
                            <div id="smartMessageBoxMain" class="mb-4 p-3 rounded-lg border hidden">
                                <div class="flex items-center">
                                    <div id="smartMessageIconMain" class="mr-3"></div>
                                    <div id="smartMessageContentMain" class="text-sm font-medium"></div>
                                </div>
                            </div>
                            <div class="w-full overflow-x-auto">
                                <table class="strategic-table">
                                    <thead>
                                        <tr>
                                            <th>Value</th>
                                            <th>Importance (100%)</th>
                                            <th>Baseline</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Threat Landscape (High)</td>
                                            <td class="importance-cell text-center">
                                                <input type="number" name="importance_high" id="importance_high"
                                                    value="{{ $df6->importance_high ?? 33.33 }}" min="0" max="100"
                                                    step="0.01"
                                                    class="w-24 px-2 py-1 text-center font-extrabold bg-white border border-gray-300 rounded focus:outline-none focus:border-green-500 df6-input">
                                                <span class="ml-1">%</span>
                                            </td>
                                            <td class="baseline-col text-center font-bold">0%</td>
                                        </tr>
                                        <tr>
                                            <td>Threat Landscape (Normal)</td>
                                            <td class="importance-cell text-center">
                                                <input type="number" name="importance_normal" id="importance_normal"
                                                    value="{{ $df6->importance_normal ?? 33.33 }}" min="0" max="100"
                                                    step="0.01"
                                                    class="w-24 px-2 py-1 text-center font-extrabold bg-white border border-gray-300 rounded focus:outline-none focus:border-green-500 df6-input">
                                                <span class="ml-1">%</span>
                                            </td>
                                            <td class="baseline-col text-center font-bold">100%</td>
                                        </tr>
                                        <tr>
                                            <td>Threat Landscape (Low)</td>
                                            <td class="importance-cell text-center">
                                                <input type="number" name="importance_low" id="importance_low"
                                                    value="{{ $df6->importance_low ?? 33.34 }}" min="0" max="100"
                                                    step="0.01"
                                                    class="w-24 px-2 py-1 text-center font-extrabold bg-white border border-gray-300 rounded focus:outline-none focus:border-green-500 df6-input">
                                                <span class="ml-1">%</span>
                                            </td>
                                            <td class="baseline-col text-center font-bold">0%</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-gray-100 font-bold">
                                            <td class="text-right pr-4">Total Importance:</td>
                                            <td class="text-center">
                                                <span id="totalPercentageDisplay" class="text-lg">100%</span>
                                                <span id="validationMessage" class="ml-2"></span>
                                            </td>
                                            <td class="text-center">100%</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @else
                            <!-- Table container for regular Design Factors -->
                            @if($type === 'DF9')
                                <div id="df9SmartMessageBox" class="mb-4 p-3 rounded-lg border hidden">
                                    <div class="flex items-center">
                                        <div id="df9SmartIcon" class="mr-3"></div>
                                        <div id="df9SmartContent" class="text-sm font-medium"></div>
                                    </div>
                                </div>
                            @elseif($type === 'DF10')
                                <div id="df10SmartMessageBox" class="mb-4 p-3 rounded-lg border hidden">
                                    <div class="flex items-center">
                                        <div id="df10SmartIcon" class="mr-3"></div>
                                        <div id="df10SmartContent" class="text-sm font-medium"></div>
                                    </div>
                                </div>
                            @endif
                            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                                <div class="lg:col-span-9 xl:col-span-10 overflow-x-auto min-w-0">
                                    <table
                                        class="{{ in_array($type, ['DF1', 'DF2', 'DF6', 'DF7', 'DF8', 'DF10', 'DF9']) ? 'strategic-table' : 'clean-table' }}">
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
                                                @elseif($type === 'DF6')
                                                    <th style="min-width: 200px;">Value</th>
                                                    <th style="min-width: 200px;">Importance (100%)</th>
                                                @elseif($type === 'DF8')
                                                    <th style="min-width: 200px;">Value</th>
                                                    <th style="min-width: 200px;">Importance (100%)</th>
                                                @elseif($type === 'DF9')
                                                    <th style="min-width: 200px;">Value</th>
                                                    <th style="min-width: 200px;">Importance (100%)</th>
                                                @elseif($type === 'DF10')
                                                    <th style="min-width: 200px;">Value</th>
                                                    <th style="min-width: 200px;">Importance (100%)</th>
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
                                                                data-key="{{ $key }}" {{ $designFactor->is_locked ? 'disabled readonly' : '' }}>
                                                        </td>
                                                        <td class="p-0">
                                                            <input type="number" name="inputs[{{ $key }}][likelihood]"
                                                                value="{{ data_get($designFactor->inputs, $key . '.likelihood', 3) }}"
                                                                min="1" max="5" class="heat-input df3-input likelihood-input"
                                                                data-key="{{ $key }}" {{ $designFactor->is_locked ? 'disabled readonly' : '' }}>
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
                                                                    <input type="radio" name="inputs[{{ $key }}][importance]"
                                                                        value="1"
                                                                        class="importance-icon-radio green importance-input"
                                                                        data-key="{{ $key }}" {{ $currentImportance == 1 ? 'checked' : '' }} {{ $designFactor->is_locked ? 'disabled' : '' }}>
                                                                </label>
                                                                <label class="flex flex-col items-center cursor-pointer">
                                                                    <input type="radio" name="inputs[{{ $key }}][importance]"
                                                                        value="2"
                                                                        class="importance-icon-radio yellow importance-input"
                                                                        data-key="{{ $key }}" {{ $currentImportance == 2 ? 'checked' : '' }} {{ $designFactor->is_locked ? 'disabled' : '' }}>
                                                                </label>
                                                                <label class="flex flex-col items-center cursor-pointer">
                                                                    <input type="radio" name="inputs[{{ $key }}][importance]"
                                                                        value="3" class="importance-icon-radio red importance-input"
                                                                        data-key="{{ $key }}" {{ $currentImportance == 3 ? 'checked' : '' }} {{ $designFactor->is_locked ? 'disabled' : '' }}>
                                                                </label>
                                                            </div>
                                                        </td>
                                                    @elseif($type === 'DF9')
                                                        <td class="importance-cell">
                                                            @php
                                                                $inputId = '';
                                                                if ($key === 'agile')
                                                                    $inputId = 'importance_agile';
                                                                elseif ($key === 'devops')
                                                                    $inputId = 'importance_devops';
                                                                elseif ($key === 'traditional')
                                                                    $inputId = 'importance_traditional';
                                                            @endphp
                                                            <input type="number" name="inputs[{{ $key }}][importance]"
                                                                id="{{ $inputId }}"
                                                                value="{{ data_get($designFactor->inputs, $key . '.importance', 33.33) }}"
                                                                min="0" max="100" step="0.01"
                                                                class="w-24 px-2 py-1 text-center font-extrabold bg-white border border-gray-300 rounded focus:outline-none focus:border-green-500 df9-input"
                                                                data-key="{{ $key }}" {{ $designFactor->is_locked ? 'disabled readonly' : '' }}>
                                                            <span class="ml-1">%</span>
                                                        </td>
                                                    @elseif($type === 'DF10')
                                                        <td class="importance-cell">
                                                            @php
                                                                $inputId = '';
                                                                if ($key === 'first_mover')
                                                                    $inputId = 'importance_first_mover';
                                                                elseif ($key === 'follower')
                                                                    $inputId = 'importance_follower';
                                                                elseif ($key === 'slow_adopter')
                                                                    $inputId = 'importance_slow_adopter';
                                                            @endphp
                                                            <input type="number" name="inputs[{{ $key }}][importance]"
                                                                id="{{ $inputId }}"
                                                                value="{{ data_get($designFactor->inputs, $key . '.importance', $key === 'first_mover' ? 75 : ($key === 'follower' ? 15 : 10)) }}"
                                                                min="0" max="100" step="0.01"
                                                                class="w-24 px-2 py-1 text-center font-extrabold bg-white border border-gray-300 rounded focus:outline-none focus:border-green-500 df10-input"
                                                                data-key="{{ $key }}" {{ $designFactor->is_locked ? 'disabled readonly' : '' }}>
                                                            <span class="ml-1">%</span>
                                                        </td>
                                                    @elseif($type === 'DF4')
                                                        <td class="importance-cell">
                                                            <div class="flex items-center justify-center gap-2">
                                                                @php
                                                                    $currentVal = data_get($designFactor->inputs, $key . '.importance', 1);
                                                                @endphp

                                                                <!-- Green (1) -->
                                                                <label class="cursor-pointer">
                                                                    <input type="radio" name="inputs[{{ $key }}][importance]"
                                                                        value="1" class="hidden peer" {{ $currentVal == 1 ? 'checked' : '' }} data-key="{{ $key }}">
                                                                    <div class="w-6 h-6 rounded-full border-2 border-gray-300 peer-checked:border-black peer-checked:scale-110 transition-all bg-[#70ad47] opacity-50 peer-checked:opacity-100"
                                                                        title="No Issue (1)"></div>
                                                                </label>

                                                                <!-- Yellow (2) -->
                                                                <label class="cursor-pointer">
                                                                    <input type="radio" name="inputs[{{ $key }}][importance]"
                                                                        value="2" class="hidden peer" {{ $currentVal == 2 ? 'checked' : '' }} data-key="{{ $key }}">
                                                                    <div class="w-6 h-6 rounded-full border-2 border-gray-300 peer-checked:border-black peer-checked:scale-110 transition-all bg-[#ffc000] opacity-50 peer-checked:opacity-100"
                                                                        title="Potential Issue (2)"></div>
                                                                </label>

                                                                <!-- Red (3) -->
                                                                <label class="cursor-pointer">
                                                                    <input type="radio" name="inputs[{{ $key }}][importance]"
                                                                        value="3" class="hidden peer" {{ $currentVal == 3 ? 'checked' : '' }} data-key="{{ $key }}">
                                                                    <div class="w-6 h-6 rounded-full border-2 border-gray-300 peer-checked:border-black peer-checked:scale-110 transition-all bg-[#c00000] opacity-50 peer-checked:opacity-100"
                                                                        title="Issue (3)"></div>
                                                                </label>
                                                            </div>
                                                        </td>
                                                    @else
                                                        <td class="importance-cell">
                                                            <input type="number" name="inputs[{{ $key }}][importance]"
                                                                value="{{ data_get($designFactor->inputs, $key . '.importance', 3) }}"
                                                                min="1" max="5"
                                                                class="w-16 px-2 py-1 text-center font-extrabold bg-white border border-gray-300 rounded focus:outline-none focus:border-green-500 importance-input"
                                                                data-key="{{ $key }}" {{ $designFactor->is_locked ? 'disabled readonly' : '' }}>
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
                                                            $currentBaseline = data_get($designFactor->inputs, $key . '.baseline', $baselineDefault);
                                                            if ($type === 'DF4') {
                                                                $currentBaseline = 2;
                                                            }
                                                        @endphp
                                                        {{ $currentBaseline }}
                                                        <input type="hidden" name="inputs[{{ $key }}][baseline]"
                                                            value="{{ $currentBaseline }}" class="baseline-input">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
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

                                @if($type === 'DF6')
                                    <!-- DF6 Total Display and Legend -->
                                    <div class="w-full lg:col-span-3 xl:col-span-2">
                                        <div class="border border-gray-400 overflow-hidden shadow-sm">
                                            <div class="bg-white p-3 border-b border-gray-400">
                                                <p class="text-sm font-bold text-gray-800">Total Importance</p>
                                                <p class="text-2xl font-bold" id="df6TotalDisplay">100%</p>
                                                <p class="text-xs text-gray-500 mt-1" id="df6Warning"></p>
                                            </div>
                                            <div class="bg-green-50 p-3">
                                                <p class="text-xs font-medium text-green-700">Total harus = 100%</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif



                                @if($type === 'DF9')
                                    <!-- Smart Message Box for DF9 -->
                                    <div id="df9SmartMessageBox"
                                        class="mb-4 p-3 rounded-lg border bg-blue-50 border-blue-200 text-blue-800">
                                        <div class="flex items-start gap-3">
                                            <div id="df9SmartIcon" class="mt-0.5">
                                                <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <p id="df9SmartContent" class="text-sm font-medium">
                                                    Total importance harus tepat 100%. Total saat ini: <span
                                                        id="df9TotalDisplay">100</span>%.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if($type === 'DF10')
                                    <!-- Smart Message Box for DF10 -->
                                    <div id="df10SmartMessageBox"
                                        class="mb-4 p-3 rounded-lg border bg-blue-50 border-blue-200 text-blue-800">
                                        <div class="flex items-start gap-3">
                                            <div id="df10SmartIcon" class="mt-0.5">
                                                <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <p id="df10SmartContent" class="text-sm font-medium">
                                                    Total importance harus tepat 100%. Total saat ini: <span
                                                        id="df10TotalDisplay">100</span>%.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                @if($type === 'DF5')
                    <!-- Section 2: DF5 Results Table -->
                    <div class="mb-6 overflow-hidden light-card rounded-xl shadow-sm">
                        <div class="p-4 border-b border-gray-200 bg-slate-50">
                            <h2 class="text-xl font-bold text-green-600">Governance/Management Objectives Results</h2>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="clean-table" id="df5ResultsTable">
                                <thead>
                                    <tr>
                                        <th>Objective</th>
                                        <th>Score</th>
                                        <th>Baseline Score</th>
                                        <th>Relative Importance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($results as $result)
                                        <tr>
                                            <td>
                                                <span
                                                    class="px-3 py-1 text-sm font-black rounded
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
                                            <td class="font-bold text-gray-700">{{ number_format($result['score'] / 100, 2) }}
                                            </td>
                                            <td class="font-bold text-gray-700">
                                                {{ number_format($result['baseline_score'] / 100, 2) }}
                                            </td>
                                            <td>
                                                <span
                                                    class="relative-importance font-black text-lg
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    @if($result['relative_importance'] > 0) value-positive
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    @elseif($result['relative_importance'] < 0) value-negative
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    @else value-neutral
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    @endif">
                                                    {{ $result['relative_importance'] > 0 ? '+' : '' }}{{ (int) $result['relative_importance'] }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Section 3: DF5 Charts -->
                    <div class="grid grid-cols-1 gap-6 mb-8 lg:grid-cols-2">
                        <div class="p-6 bg-white border border-gray-200 shadow-sm rounded-xl">
                            <h2 class="text-lg font-bold text-gray-800 mb-2">DF5 Output</h2>
                            <div class="relative" style="height: 700px;">
                                <canvas id="df5BarChart"></canvas>
                            </div>
                        </div>
                        <div class="p-6 bg-white border border-gray-200 shadow-sm rounded-xl">
                            <h2 class="text-lg font-bold text-gray-800 mb-2">DF5 Radar</h2>
                            <div class="relative" style="height: 700px;">
                                <canvas id="df5RadarChart"></canvas>
                            </div>
                        </div>
                    </div>
                @elseif($type === 'DF6')
                    <!-- Section 2: DF6 Results Table -->
                    <div class="mb-6 overflow-hidden light-card rounded-xl shadow-sm">
                        <div class="p-4 border-b border-gray-200 bg-slate-50">
                            <h2 class="text-xl font-bold text-green-600">Governance/Management Objectives Results</h2>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="clean-table" id="df6ResultsTable">
                                <thead>
                                    <tr>
                                        <th>Objective</th>
                                        <th>Score</th>
                                        <th>Baseline Score</th>
                                        <th>Relative Importance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($results as $result)
                                        <tr>
                                            <td>
                                                <span
                                                    class="px-3 py-1 text-sm font-black rounded
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
                                            <td class="font-bold text-gray-700">{{ number_format($result['score'] / 100, 2) }}
                                            </td>
                                            <td class="font-bold text-gray-700">
                                                {{ number_format($result['baseline_score'] / 100, 2) }}
                                            </td>
                                            <td>
                                                <span
                                                    class="relative-importance font-black text-lg
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            @if($result['relative_importance'] > 0) value-positive
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            @elseif($result['relative_importance'] < 0) value-negative
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            @else value-neutral
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            @endif">
                                                    {{ $result['relative_importance'] > 0 ? '+' : '' }}{{ (int) $result['relative_importance'] }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Section 3: DF6 Charts -->
                    <div class="grid grid-cols-1 gap-6 mb-8 lg:grid-cols-2">
                        <div class="p-6 bg-white border border-gray-200 shadow-sm rounded-xl">
                            <h2 class="text-lg font-bold text-gray-800 mb-2">DF6 Output</h2>
                            <div class="relative" style="height: 700px;">
                                <canvas id="df6BarChart"></canvas>
                            </div>
                        </div>
                        <div class="p-6 bg-white border border-gray-200 shadow-sm rounded-xl">
                            <h2 class="text-lg font-bold text-gray-800 mb-2">DF6 Radar</h2>
                            <div class="relative" style="height: 700px;">
                                <canvas id="df6RadarChart"></canvas>
                            </div>
                        </div>
                    </div>
                @elseif($type === 'DF8')
                    <!-- Section 2: DF8 Results Table -->
                    <div class="mb-6 overflow-hidden light-card rounded-xl shadow-sm">
                        <div class="p-4 border-b border-gray-200 bg-slate-50">
                            <h2 class="text-xl font-bold text-green-600">Governance/Management Objectives Results</h2>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="clean-table" id="df8ResultsTable">
                                <thead>
                                    <tr>
                                        <th>Objective</th>
                                        <th>Score</th>
                                        <th>Baseline Score</th>
                                        <th>Relative Importance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($results as $index => $result)
                                        <tr>
                                            <td>
                                                <span
                                                    class="px-3 py-1 text-sm font-black rounded
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     @if(str_starts_with($result['code'], 'EDM')) badge-edm
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     @elseif(str_starts_with($result['code'], 'APO')) badge-apo
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     @elseif(str_starts_with($result['code'], 'BAI')) badge-bai
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     @elseif(str_starts_with($result['code'], 'DSS')) badge-dss
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     @elseif(str_starts_with($result['code'], 'MEA')) badge-mea
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     @endif">
                                                    {{ $result['code'] }}
                                                </span>
                                                <input type="hidden" name="items[{{ $index }}][code]"
                                                    value="{{ $result['code'] }}">
                                                <input type="hidden" name="items[{{ $index }}][score]"
                                                    value="{{ $result['score'] }}" class="item-score-hidden">
                                                <input type="hidden" name="items[{{ $index }}][baseline_score]"
                                                    value="{{ $result['baseline_score'] }}" class="item-baseline-hidden">

                                                @if(isset($df8Mapping[$result['code']]))
                                                    <input type="hidden" class="item-outsourcing-value"
                                                        value="{{ $df8Mapping[$result['code']]['outsourcing'] }}">
                                                    <input type="hidden" class="item-cloud-value"
                                                        value="{{ $df8Mapping[$result['code']]['cloud'] }}">
                                                    <input type="hidden" class="item-insourced-value"
                                                        value="{{ $df8Mapping[$result['code']]['insourced'] }}">
                                                @endif
                                                <span class="ml-2">{{ $result['name'] }}</span>
                                            </td>
                                            <td class="font-bold text-gray-700 item-score-display">
                                                {{ number_format($result['score'], 1) }}
                                            </td>
                                            <td class="font-bold text-gray-700 item-baseline-display">
                                                {{ number_format($result['baseline_score'], 2) }}
                                            </td>
                                            <td>
                                                <span
                                                    class="relative-importance font-black text-lg
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     @if($result['relative_importance'] > 0) value-positive
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     @elseif($result['relative_importance'] < 0) value-negative
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     @else value-neutral
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     @endif">
                                                    {{ $result['relative_importance'] > 0 ? '+' : '' }}{{ (int) $result['relative_importance'] }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Section 3: DF8 Charts -->
                    <div class="grid grid-cols-1 gap-6 mb-8 lg:grid-cols-2">
                        <div class="p-6 bg-white border border-gray-200 shadow-sm rounded-xl">
                            <h2 class="text-lg font-bold text-gray-800 mb-2">DF8 Output</h2>
                            <div class="relative" style="height: 700px;">
                                <canvas id="df8BarChart"></canvas>
                            </div>
                        </div>
                        <div class="p-6 bg-white border border-gray-200 shadow-sm rounded-xl">
                            <h2 class="text-lg font-bold text-gray-800 mb-2">DF8 Radar</h2>
                            <div class="relative" style="height: 700px;">
                                <canvas id="df8RadarChart"></canvas>
                            </div>
                        </div>
                    </div>
                @elseif($type === 'DF9')
                    <!-- Section 2: DF9 Results Table -->
                    <div class="mb-6 overflow-hidden light-card rounded-xl shadow-sm">
                        <div class="p-4 border-b border-gray-200 bg-slate-50">
                            <h2 class="text-xl font-bold text-green-600">Governance/Management Objectives Results</h2>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="clean-table" id="df9ResultsTable">
                                <thead>
                                    <tr>
                                        <th>Objective</th>
                                        <th>Score</th>
                                        <th>Baseline Score</th>
                                        <th>Relative Importance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($results as $index => $result)
                                        <tr>
                                            <td>
                                                <span
                                                    class="px-3 py-1 text-sm font-black rounded
                                                                                                                                                                                                                                    @if(str_starts_with($result['code'], 'EDM')) badge-edm
                                                                                                                                                                                                                                    @elseif(str_starts_with($result['code'], 'APO')) badge-apo
                                                                                                                                                                                                                                    @elseif(str_starts_with($result['code'], 'BAI')) badge-bai
                                                                                                                                                                                                                                    @elseif(str_starts_with($result['code'], 'DSS')) badge-dss
                                                                                                                                                                                                                                    @elseif(str_starts_with($result['code'], 'MEA')) badge-mea
                                                                                                                                                                                                                                    @endif">
                                                    {{ $result['code'] }}
                                                </span>
                                                <input type="hidden" name="items[{{ $index }}][code]"
                                                    value="{{ $result['code'] }}">
                                                <input type="hidden" name="items[{{ $index }}][score]"
                                                    value="{{ $result['score'] }}" class="item-score-hidden">
                                                <input type="hidden" name="items[{{ $index }}][baseline_score]"
                                                    value="{{ $result['baseline_score'] }}" class="item-baseline-hidden">

                                                @if(isset($df9Mapping[$result['code']]))
                                                    <input type="hidden" class="item-agile-value"
                                                        value="{{ $df9Mapping[$result['code']]['agile'] }}">
                                                    <input type="hidden" class="item-devops-value"
                                                        value="{{ $df9Mapping[$result['code']]['devops'] }}">
                                                    <input type="hidden" class="item-traditional-value"
                                                        value="{{ $df9Mapping[$result['code']]['traditional'] }}">
                                                @endif

                                                <span class="ml-2">{{ $result['name'] }}</span>
                                            </td>
                                            <td class="font-bold text-gray-700 item-score-display">
                                                {{ number_format($result['score'], 2) }}
                                            </td>
                                            <td class="font-bold text-gray-700 item-baseline-display">
                                                {{ number_format($result['baseline_score'], 2) }}
                                            </td>
                                            <td>
                                                <span
                                                    class="relative-importance font-black text-lg
                                                                                                                                                                                                                                    @if($result['relative_importance'] > 0) value-positive
                                                                                                                                                                                                                                    @elseif($result['relative_importance'] < 0) value-negative
                                                                                                                                                                                                                                    @else value-neutral
                                                                                                                                                                                                                                    @endif">
                                                    {{ $result['relative_importance'] > 0 ? '+' : '' }}{{ (int) $result['relative_importance'] }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Section 3: DF9 Charts -->
                    <div class="grid grid-cols-1 gap-6 mb-8 lg:grid-cols-2">
                        <div class="p-6 bg-white border border-gray-200 shadow-sm rounded-xl">
                            <h2 class="text-lg font-bold text-gray-800 mb-2">DF9 Output</h2>
                            <div class="relative" style="height: 700px;">
                                <canvas id="df9BarChart"></canvas>
                            </div>
                        </div>
                        <div class="p-6 bg-white border border-gray-200 shadow-sm rounded-xl">
                            <h2 class="text-lg font-bold text-gray-800 mb-2">DF9 Radar</h2>
                            <div class="relative" style="height: 700px;">
                                <canvas id="df9RadarChart"></canvas>
                            </div>
                        </div>
                    </div>
                @elseif($type === 'DF10')
                    <!-- Section 2: DF10 Results -->
                    <!-- Results Table -->
                    <div class="mb-6 overflow-hidden light-card rounded-xl shadow-sm">
                        <div class="p-4 border-b border-gray-200 bg-slate-50">
                            <h2 class="text-xl font-bold text-gray-800">Governance/Management Objectives Results</h2>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="clean-table" id="df10ResultsTable">
                                <thead>
                                    <tr>
                                        <th>Governance / Management Objective</th>
                                        <th>Score</th>
                                        <th>Baseline Score</th>
                                        <th>Relative Importance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($results as $index => $result)
                                        <tr>
                                            <td>
                                                <span
                                                    class="px-3 py-1 text-sm font-black rounded
                                                                                                                                                                            @if(str_starts_with($result['code'], 'EDM')) badge-edm
                                                                                                                                                                            @elseif(str_starts_with($result['code'], 'APO')) badge-apo
                                                                                                                                                                            @elseif(str_starts_with($result['code'], 'BAI')) badge-bai
                                                                                                                                                                            @elseif(str_starts_with($result['code'], 'DSS')) badge-dss
                                                                                                                                                                            @elseif(str_starts_with($result['code'], 'MEA')) badge-mea
                                                                                                                                                                            @endif">
                                                    {{ $result['code'] }}
                                                </span>
                                                <input type="hidden" name="items[{{ $index }}][code]"
                                                    value="{{ $result['code'] }}">
                                                <input type="hidden" name="items[{{ $index }}][score]"
                                                    value="{{ $result['score'] }}" class="item-score-hidden">
                                                <input type="hidden" name="items[{{ $index }}][baseline_score]"
                                                    value="{{ $result['baseline_score'] }}" class="item-baseline-hidden">

                                                @if(isset($df10Mapping[$result['code']]))
                                                    <input type="hidden" class="item-first-mover-value"
                                                        value="{{ $df10Mapping[$result['code']]['first_mover'] }}">
                                                    <input type="hidden" class="item-follower-value"
                                                        value="{{ $df10Mapping[$result['code']]['follower'] }}">
                                                    <input type="hidden" class="item-slow-adopter-value"
                                                        value="{{ $df10Mapping[$result['code']]['slow_adopter'] }}">
                                                @endif

                                                <span class="ml-2">{{ $result['name'] }}</span>
                                            </td>
                                            <td class="font-bold text-gray-700 item-score-display">
                                                {{ number_format($result['score'], 2) }}
                                            </td>
                                            <td class="font-bold text-gray-700 item-baseline-display">
                                                {{ number_format($result['baseline_score'], 2) }}
                                            </td>
                                            <td>
                                                <span
                                                    class="relative-importance font-black text-lg
                                                                                                                                                                            @if($result['relative_importance'] > 0) value-positive
                                                                                                                                                                            @elseif($result['relative_importance'] < 0) value-negative
                                                                                                                                                                            @else value-neutral
                                                                                                                                                                            @endif">
                                                    {{ $result['relative_importance'] > 0 ? '+' : '' }}{{ (int) $result['relative_importance'] }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Section 3: DF10 Charts -->
                    <div class="grid grid-cols-1 gap-6 mb-8 lg:grid-cols-2">
                        <div class="p-6 bg-white border border-gray-200 shadow-sm rounded-xl">
                            <h2 class="text-lg font-bold text-gray-800 mb-2">DF10 Output</h2>
                            <div class="relative" style="height: 700px;">
                                <canvas id="df10BarChart"></canvas>
                            </div>
                        </div>
                        <div class="p-6 bg-white border border-gray-200 shadow-sm rounded-xl">
                            <h2 class="text-lg font-bold text-gray-800 mb-2">DF10 Radar</h2>
                            <div class="relative" style="height: 700px;">
                                <canvas id="df10RadarChart"></canvas>
                            </div>
                        </div>
                    </div>
                @else

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
                                        <th>Mapping Score</th>
                                        <th>Mapping Baseline</th>
                                        <th>Relative Importance</th>
                                    </tr>
                                </thead>
                                <tbody>
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
                                                    value="{{ $item->score }}" class="item-score-hidden">
                                                <input type="hidden" name="items[{{ $index }}][baseline_score]"
                                                    value="{{ $item->baseline_score }}" class="item-baseline-hidden">
                                                @if($type === 'DF6' && isset($df6Mapping[$item->code]))
                                                    <input type="hidden" class="item-high-value"
                                                        value="{{ $df6Mapping[$item->code]['high'] }}">
                                                    <input type="hidden" class="item-normal-value"
                                                        value="{{ $df6Mapping[$item->code]['normal'] }}">
                                                    <input type="hidden" class="item-low-value"
                                                        value="{{ $df6Mapping[$item->code]['low'] }}">
                                                @endif
                                                @if($type === 'DF7' && isset($df7Mapping[$item->code]))
                                                    <input type="hidden" class="item-support-value"
                                                        value="{{ $df7Mapping[$item->code]['support'] }}">
                                                    <input type="hidden" class="item-factory-value"
                                                        value="{{ $df7Mapping[$item->code]['factory'] }}">
                                                    <input type="hidden" class="item-turnaround-value"
                                                        value="{{ $df7Mapping[$item->code]['turnaround'] }}">
                                                    <input type="hidden" class="item-strategic-value"
                                                        value="{{ $df7Mapping[$item->code]['strategic'] }}">
                                                @endif
                                                @if($type === 'DF8' && isset($df8Mapping[$item->code]))
                                                    <input type="hidden" class="item-outsourcing-value"
                                                        value="{{ $df8Mapping[$item->code]['outsourcing'] }}">
                                                    <input type="hidden" class="item-cloud-value"
                                                        value="{{ $df8Mapping[$item->code]['cloud'] }}">
                                                    <input type="hidden" class="item-insourced-value"
                                                        value="{{ $df8Mapping[$item->code]['insourced'] }}">
                                                @endif
                                                @if($type === 'DF9' && isset($df9Mapping[$item->code]))
                                                    <input type="hidden" class="item-agile-value"
                                                        value="{{ $df9Mapping[$item->code]['agile'] }}">
                                                    <input type="hidden" class="item-devops-value"
                                                        value="{{ $df9Mapping[$item->code]['devops'] }}">
                                                    <input type="hidden" class="item-traditional-value"
                                                        value="{{ $df9Mapping[$item->code]['traditional'] }}">
                                                @endif
                                                @if($type === 'DF10' && isset($df10Mapping[$item->code]))
                                                    <input type="hidden" class="item-first-mover-value"
                                                        value="{{ $df10Mapping[$item->code]['first_mover'] }}">
                                                    <input type="hidden" class="item-follower-value"
                                                        value="{{ $df10Mapping[$item->code]['follower'] }}">
                                                    <input type="hidden" class="item-slow-adopter-value"
                                                        value="{{ $df10Mapping[$item->code]['slow_adopter'] }}">
                                                @endif
                                            </td>
                                            <td class="font-bold text-gray-700 item-score-display">{{ $item->score }}
                                            </td>
                                            <td class="font-bold text-gray-700 item-baseline-display">
                                                @if($type === 'DF4')
                                                    @php
                                                        $df4Baselines = [
                                                            'EDM01' => 70,
                                                            'EDM02' => 70,
                                                            'EDM03' => 47,
                                                            'EDM04' => 67,
                                                            'EDM05' => 41,
                                                            'APO01' => 56,
                                                            'APO02' => 50,
                                                            'APO03' => 66,
                                                            'APO04' => 32,
                                                            'APO05' => 68,
                                                            'APO06' => 62,
                                                            'APO07' => 47,
                                                            'APO08' => 70,
                                                            'APO09' => 43,
                                                            'APO10' => 39,
                                                            'APO11' => 43,
                                                            'APO12' => 52,
                                                            'APO13' => 33,
                                                            'APO14' => 60,
                                                            'BAI01' => 35,
                                                            'BAI02' => 51,
                                                            'BAI03' => 41,
                                                            'BAI04' => 23,
                                                            'BAI05' => 28,
                                                            'BAI06' => 42,
                                                            'BAI07' => 38,
                                                            'BAI08' => 31,
                                                            'BAI09' => 23,
                                                            'BAI10' => 25,
                                                            'BAI11' => 45,
                                                            'DSS01' => 27,
                                                            'DSS02' => 33,
                                                            'DSS03' => 32,
                                                            'DSS04' => 21,
                                                            'DSS05' => 29,
                                                            'DSS06' => 29,
                                                            'MEA01' => 61,
                                                            'MEA02' => 48,
                                                            'MEA03' => 59,
                                                            'MEA04' => 41,
                                                        ];
                                                    @endphp
                                                    {{ number_format($df4Baselines[$item->code] ?? $item->baseline_score, 2) }}
                                                @else
                                                    {{ in_array($type, ['DF8', 'DF9', 'DF10']) ? number_format($item->baseline_score, 2) : $item->baseline_score }}
                                                @endif
                                            </td>
                                            <td>
                                                <span
                                                    class="relative-importance font-black text-lg
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
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Section 4: Charts -->
                    <div class="grid grid-cols-1 gap-6 mb-8 lg:grid-cols-2">
                        <div class="p-6 bg-white border border-gray-200 shadow-sm rounded-xl">
                            <h2 class="text-lg font-bold text-gray-800 mb-2">{{ $type }} Output</h2>
                            <div class="relative" style="height: 700px;">
                                <canvas id="barChart"></canvas>
                            </div>
                        </div>

                        <div class="p-6 bg-white border border-gray-200 shadow-sm rounded-xl">
                            <h2 class="text-lg font-bold text-gray-800 mb-2">{{ $type }} Radar</h2>
                            <div class="relative" style="height: 700px;">
                                <canvas id="radarChart"></canvas>
                            </div>
                        </div>
                    </div>

                @endif
                <div class="flex justify-center gap-4 p-6 bg-slate-50 border border-gray-200 rounded-xl shadow-inner">
                    @if(isset($designFactor) && $designFactor->is_locked)
                        <div
                            class="flex items-center px-10 py-4 text-base font-bold text-gray-600 bg-gray-300 rounded-xl shadow-lg cursor-not-allowed">
                            <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Terkunci
                        </div>
                    @else
                        <button type="submit" id="saveBtnMain"
                            class="flex items-center px-10 py-4 text-base font-bold text-white bg-green-600 rounded-xl hover:bg-green-700 transform hover:scale-105 transition-all shadow-lg">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                                </path>
                            </svg>
                            Simpan Analisis {{ $type }}
                        </button>

                        <!-- Reset All Button -->
                        <button type="button" id="resetAllBtn"
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
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const factorType = "{{ $type }}";

                const importanceInputs = document.querySelectorAll('.importance-input');
                const df3Inputs = document.querySelectorAll('.df3-input');
                const baselineInputs = document.querySelectorAll('.baseline-input');

                let chartLabels = @json($designFactor->items->pluck('code'));
                let chartData = [];
                // Chart variables will be created implicitly when assigned

                // Initialize itemScores and itemBaselines arrays from DOM
                const itemScoreHiddens = document.querySelectorAll('.item-score-hidden');
                const itemBaselineHiddens = document.querySelectorAll('.item-baseline-hidden');
                const itemScoreDisplays = document.querySelectorAll('.item-score-display');
                const itemBaselineDisplays = document.querySelectorAll('.item-baseline-display');

                let itemScores = [];
                let itemBaselines = [];

                // Populate from hidden inputs
                itemScoreHiddens.forEach((input, index) => {
                    itemScores[index] = parseFloat(input.value) || 0;
                });
                itemBaselineHiddens.forEach((input, index) => {
                    itemBaselines[index] = parseFloat(input.value) || 0;
                });

                // Initialize DF6 mapping values
                const df6HighInputs = document.querySelectorAll('.item-high-value');
                const df6NormalInputs = document.querySelectorAll('.item-normal-value');
                const df6LowInputs = document.querySelectorAll('.item-low-value');
                let df6HighValues = [];
                let df6NormalValues = [];
                let df6LowValues = [];
                df6HighInputs.forEach((input, index) => { df6HighValues[index] = parseFloat(input.value) || 0; });
                df6NormalInputs.forEach((input, index) => { df6NormalValues[index] = parseFloat(input.value) || 0; });
                df6LowInputs.forEach((input, index) => { df6LowValues[index] = parseFloat(input.value) || 0; });

                // Initialize DF7 mapping values
                const df7SupportInputs = document.querySelectorAll('.item-support-value');
                const df7FactoryInputs = document.querySelectorAll('.item-factory-value');
                const df7TurnaroundInputs = document.querySelectorAll('.item-turnaround-value');
                const df7StrategicInputs = document.querySelectorAll('.item-strategic-value');
                let df7SupportValues = [];
                let df7FactoryValues = [];
                let df7TurnaroundValues = [];
                let df7StrategicValues = [];
                df7SupportInputs.forEach((input, index) => { df7SupportValues[index] = parseFloat(input.value) || 0; });
                df7FactoryInputs.forEach((input, index) => { df7FactoryValues[index] = parseFloat(input.value) || 0; });
                df7TurnaroundInputs.forEach((input, index) => { df7TurnaroundValues[index] = parseFloat(input.value) || 0; });
                df7StrategicInputs.forEach((input, index) => { df7StrategicValues[index] = parseFloat(input.value) || 0; });

                // Initialize DF8 mapping values
                const df8OutsourcingInputs = document.querySelectorAll('.item-outsourcing-value');
                const df8CloudInputs = document.querySelectorAll('.item-cloud-value');
                const df8InsourcedInputs = document.querySelectorAll('.item-insourced-value');
                let df8OutsourcingValues = [];
                let df8CloudValues = [];
                let df8InsourcedValues = [];
                df8OutsourcingInputs.forEach((input, index) => { df8OutsourcingValues[index] = parseFloat(input.value) || 0; });
                df8CloudInputs.forEach((input, index) => { df8CloudValues[index] = parseFloat(input.value) || 0; });
                df8InsourcedInputs.forEach((input, index) => { df8InsourcedValues[index] = parseFloat(input.value) || 0; });

                // Initialize DF9 mapping values
                const df9AgileInputs = document.querySelectorAll('.item-agile-value');
                const df9DevopsInputs = document.querySelectorAll('.item-devops-value');
                const df9TraditionalInputs = document.querySelectorAll('.item-traditional-value');
                let df9AgileValues = [];
                let df9DevopsValues = [];
                let df9TraditionalValues = [];
                df9AgileInputs.forEach((input, index) => { df9AgileValues[index] = parseFloat(input.value) || 0; });
                df9DevopsInputs.forEach((input, index) => { df9DevopsValues[index] = parseFloat(input.value) || 0; });
                df9TraditionalInputs.forEach((input, index) => { df9TraditionalValues[index] = parseFloat(input.value) || 0; });

                // Initialize DF10 mapping values
                const df10FirstMoverInputs = document.querySelectorAll('.item-first-mover-value');
                const df10FollowerInputs = document.querySelectorAll('.item-follower-value');
                const df10SlowAdopterInputs = document.querySelectorAll('.item-slow-adopter-value');
                let df10FirstMoverValues = [];
                let df10FollowerValues = [];
                let df10SlowAdopterValues = [];
                df10FirstMoverInputs.forEach((input, index) => { df10FirstMoverValues[index] = parseFloat(input.value) || 0; });
                df10FollowerInputs.forEach((input, index) => { df10FollowerValues[index] = parseFloat(input.value) || 0; });
                df10SlowAdopterInputs.forEach((input, index) => { df10SlowAdopterValues[index] = parseFloat(input.value) || 0; });

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

                            if (dot) {
                                dot.className = 'w-4 h-4 rounded-full risk-dot shadow-sm';
                                dot.style.border = '1px solid #000';
                                if (rating >= 15) dot.style.backgroundColor = '#c00000'; // Very High
                                else if (rating >= 8) dot.style.backgroundColor = '#edbd70'; // High
                                else if (rating >= 4) dot.style.backgroundColor = '#72a488'; // Normal
                                else dot.style.backgroundColor = '#4b4b4b'; // Low
                            }
                        }
                    }
                }
                let df5BarChart = null;
                let df5RadarChart = null;
                let df6BarChart = null;
                let df6RadarChart = null;
                let df8BarChart = null;
                let df8RadarChart = null;
                let df9BarChart = null;
                let df9RadarChart = null;
                let df10BarChart = null;
                let df10RadarChart = null;

                function initCharts() {
                    if (factorType === 'DF5') {
                        const barCanvas = document.getElementById('df5BarChart');
                        const radarCanvas = document.getElementById('df5RadarChart');
                        if (!barCanvas || !radarCanvas) return;

                        const barCtx = barCanvas.getContext('2d');
                        const radarCtx = radarCanvas.getContext('2d');

                        const results = @json($results ?? []);
                        const labels = results.map(r => r.code);
                        const data = results.map(r => r.relative_importance);

                        df5BarChart = new Chart(barCtx, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Relative Importance',
                                    data: data,
                                    backgroundColor: data.map(v => v >= 0 ? 'rgba(79, 124, 53, 0.7)' : 'rgba(192, 0, 0, 0.7)'),
                                    borderColor: data.map(v => v >= 0 ? 'rgba(79, 124, 53, 1)' : 'rgba(192, 0, 0, 1)'),
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
                                    y: { grid: { display: false }, ticks: { font: { weight: 'bold' } } }
                                }
                            }
                        });

                        df5RadarChart = new Chart(radarCtx, {
                            type: 'radar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Relative Importance',
                                    data: data.map(v => v + 100),
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
                                        min: 0, max: 200,
                                        ticks: { stepSize: 50, callback: v => v - 100, backdropColor: 'transparent' },
                                        pointLabels: { font: { size: 10, weight: 'bold' } }
                                    }
                                }
                            }
                        });
                        return;
                    }

                    if (factorType === 'DF6') {
                        const barCanvas = document.getElementById('df6BarChart');
                        const radarCanvas = document.getElementById('df6RadarChart');
                        if (!barCanvas || !radarCanvas) return;

                        const barCtx = barCanvas.getContext('2d');
                        const radarCtx = radarCanvas.getContext('2d');

                        const results = @json($results ?? []);
                        const labels = results.map(r => r.code);
                        const data = results.map(r => r.relative_importance);

                        df6BarChart = new Chart(barCtx, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Relative Importance',
                                    data: data,
                                    backgroundColor: data.map(v => v >= 0 ? 'rgba(79, 124, 53, 0.7)' : 'rgba(192, 0, 0, 0.7)'),
                                    borderColor: data.map(v => v >= 0 ? 'rgba(79, 124, 53, 1)' : 'rgba(192, 0, 0, 1)'),
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
                                    y: { grid: { display: false }, ticks: { font: { weight: 'bold' } } }
                                }
                            }
                        });

                        df6RadarChart = new Chart(radarCtx, {
                            type: 'radar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Relative Importance',
                                    data: data.map(v => v + 100),
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
                                        min: 0, max: 200,
                                        ticks: { stepSize: 50, callback: v => v - 100, backdropColor: 'transparent' },
                                        pointLabels: { font: { size: 10, weight: 'bold' } }
                                    }
                                }
                            }
                        });
                        return;
                    }

                    if (factorType === 'DF8') {
                        const barCanvas = document.getElementById('df8BarChart');
                        const radarCanvas = document.getElementById('df8RadarChart');
                        if (!barCanvas || !radarCanvas) return;

                        const barCtx = barCanvas.getContext('2d');
                        const radarCtx = radarCanvas.getContext('2d');

                        const results = @json($results ?? []);
                        const labels = results.map(r => r.code);
                        const data = results.map(r => r.relative_importance);

                        df8BarChart = new Chart(barCtx, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Relative Importance',
                                    data: data,
                                    backgroundColor: data.map(v => v >= 0 ? 'rgba(79, 124, 53, 0.7)' : 'rgba(192, 0, 0, 0.7)'),
                                    borderColor: data.map(v => v >= 0 ? 'rgba(79, 124, 53, 1)' : 'rgba(192, 0, 0, 1)'),
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
                                    y: { grid: { display: false }, ticks: { font: { weight: 'bold' } } }
                                }
                            }
                        });

                        df8RadarChart = new Chart(radarCtx, {
                            type: 'radar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Relative Importance',
                                    data: data.map(v => v + 100),
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
                                        min: 0, max: 200,
                                        ticks: { stepSize: 50, callback: v => v - 100, backdropColor: 'transparent' },
                                        pointLabels: { font: { size: 10, weight: 'bold' } }
                                    }
                                }
                            }
                        });
                        return;
                    }

                    if (factorType === 'DF9') {
                        const barCanvas = document.getElementById('df9BarChart');
                        const radarCanvas = document.getElementById('df9RadarChart');
                        if (!barCanvas || !radarCanvas) return;

                        const barCtx = barCanvas.getContext('2d');
                        const radarCtx = radarCanvas.getContext('2d');

                        const results = @json($results ?? []);
                        const labels = results.map(r => r.code);
                        const data = results.map(r => r.relative_importance);

                        df9BarChart = new Chart(barCtx, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Relative Importance',
                                    data: data,
                                    backgroundColor: data.map(v => v >= 0 ? 'rgba(79, 124, 53, 0.7)' : 'rgba(192, 0, 0, 0.7)'),
                                    borderColor: data.map(v => v >= 0 ? 'rgba(79, 124, 53, 1)' : 'rgba(192, 0, 0, 1)'),
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
                                    y: { grid: { display: false }, ticks: { font: { weight: 'bold' } } }
                                }
                            }
                        });

                        df9RadarChart = new Chart(radarCtx, {
                            type: 'radar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Relative Importance',
                                    data: data.map(v => v + 100),
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
                                        min: 0, max: 200,
                                        ticks: { stepSize: 50, callback: v => v - 100, backdropColor: 'transparent' },
                                        pointLabels: { font: { size: 10, weight: 'bold' } }
                                    }
                                }
                            }
                        });
                        return;
                    }

                    if (factorType === 'DF10') {
                        const barCanvas = document.getElementById('df10BarChart');
                        const radarCanvas = document.getElementById('df10RadarChart');
                        if (!barCanvas || !radarCanvas) return;

                        const barCtx = barCanvas.getContext('2d');
                        const radarCtx = radarCanvas.getContext('2d');

                        const results = @json($results ?? []);
                        const labels = results.map(r => r.code);
                        const data = results.map(r => r.relative_importance);

                        df10BarChart = new Chart(barCtx, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Relative Importance',
                                    data: data,
                                    backgroundColor: data.map(v => v >= 0 ? 'rgba(79, 124, 53, 0.7)' : 'rgba(192, 0, 0, 0.7)'),
                                    borderColor: data.map(v => v >= 0 ? 'rgba(79, 124, 53, 1)' : 'rgba(192, 0, 0, 1)'),
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
                                    y: { grid: { display: false }, ticks: { font: { weight: 'bold' } } }
                                }
                            }
                        });

                        df10RadarChart = new Chart(radarCtx, {
                            type: 'radar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Relative Importance',
                                    data: data.map(v => v + 100),
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
                                        min: 0, max: 200,
                                        ticks: { stepSize: 50, callback: v => v - 100, backdropColor: 'transparent' },
                                        pointLabels: { font: { size: 10, weight: 'bold' } }
                                    }
                                }
                            }
                        });
                        return;
                    }

                    // For DF1, DF2, DF3, DF4, DF7 - use general barChart and radarChart
                    const barCanvas = document.getElementById('barChart');
                    const radarCanvas = document.getElementById('radarChart');
                    if (!barCanvas || !radarCanvas) return;

                    const barCtx = barCanvas.getContext('2d');
                    const radarCtx = radarCanvas.getContext('2d');

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
                            plugins: { legend: { display: false } },
                            scales: {
                                x: { min: -100, max: 100, grid: { color: '#e5e7eb' }, ticks: { stepSize: 25 } },
                                y: { grid: { display: false }, ticks: { font: { weight: 'bold' } } }
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
                                    min: 0, max: 200,
                                    ticks: { stepSize: 50, callback: v => v - 100, backdropColor: 'transparent' },
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
                    barChart.data.datasets[0].borderColor = chartData.map(v => v >= 0 ? 'rgba(79, 124, 53, 1)' : 'rgba(192, 0, 0, 1)');
                    barChart.update('none');
                    radarChart.data.datasets[0].data = chartData.map(v => v + 100);
                    radarChart.update('none');
                }

                function calculate() {
                    updateRiskDisplays();
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
                    } else if (factorType === 'DF6') {
                        // DF6: Percentage-based calculation with dynamic score
                        const highInput = document.getElementById('importance_high');
                        const normalInput = document.getElementById('importance_normal');
                        const lowInput = document.getElementById('importance_low');

                        let high = parseFloat(highInput?.value) || 0;
                        let normal = parseFloat(normalInput?.value) || 0;
                        let low = parseFloat(lowInput?.value) || 0;

                        const total = high + normal + low;
                        const totalPercentageDisplay = document.getElementById('totalPercentageDisplay');
                        const validationMessage = document.getElementById('validationMessage');

                        // Update total display
                        if (totalPercentageDisplay) {
                            totalPercentageDisplay.textContent = total.toFixed(2) + '%';
                        }

                        // Validation message
                        if (validationMessage) {
                            if (Math.abs(total - 100) < 0.01) {
                                validationMessage.innerHTML = '<span class="validation-success">✓ Valid</span>';
                            } else {
                                validationMessage.innerHTML = '<span class="validation-error">✗ Harus 100%</span>';
                            }
                        }

                        // Convert percentages to decimals for MMULT calculation
                        const highDec = high / 100;
                        const normalDec = normal / 100;
                        const lowDec = low / 100;

                        // Recalculate all item scores using MMULT formula: Score = (High * High%) + (Normal * Normal%) + (Low * Low%)
                        for (let i = 0; i < df6HighValues.length; i++) {
                            const newScore = (df6HighValues[i] * highDec) + (df6NormalValues[i] * normalDec) + (df6LowValues[i] * lowDec);
                            itemScores[i] = newScore;

                            // Update hidden input and display
                            if (itemScoreHiddens[i]) itemScoreHiddens[i].value = newScore.toFixed(2);
                            if (itemScoreDisplays[i]) itemScoreDisplays[i].textContent = newScore.toFixed(2);
                        }

                        // Weighted average: (High% * 5) + (Normal% * 3) + (Low% * 1) / 100
                        totalVal = (high * 5 + normal * 3 + low * 1) / 100;
                        count = 1;

                        // Get baseline average
                        let highBase = 0, normalBase = 100, lowBase = 0;
                        baselineInputs.forEach(input => {
                            const name = input.name;
                            if (name.includes('high')) highBase = parseFloat(input.value) || 0;
                            else if (name.includes('normal')) normalBase = parseFloat(input.value) || 100;
                            else if (name.includes('low')) lowBase = parseFloat(input.value) || 0;
                        });
                        totalBase = (highBase + normalBase + lowBase) / 3;
                    } else if (factorType === 'DF7') {
                        // DF7: MMULT calculation = (Support * Support_imp) + (Factory * Factory_imp) + (Turnaround * Turnaround_imp) + (Strategic * Strategic_imp)
                        let supportImp = 1, factoryImp = 1, turnaroundImp = 2, strategicImp = 5;
                        importanceInputs.forEach(input => {
                            const key = input.dataset.key;
                            const val = parseFloat(input.value) || 1;
                            if (key === 'support') supportImp = val;
                            else if (key === 'factory') factoryImp = val;
                            else if (key === 'turnaround') turnaroundImp = val;
                            else if (key === 'strategic') strategicImp = val;
                        });

                        // Recalculate all item scores using MMULT formula
                        for (let i = 0; i < df7SupportValues.length; i++) {
                            const newScore = (df7SupportValues[i] * supportImp) +
                                (df7FactoryValues[i] * factoryImp) +
                                (df7TurnaroundValues[i] * turnaroundImp) +
                                (df7StrategicValues[i] * strategicImp);
                            itemScores[i] = newScore;

                            // Update hidden input and display
                            if (itemScoreHiddens[i]) itemScoreHiddens[i].value = newScore.toFixed(1);
                            if (itemScoreDisplays[i]) itemScoreDisplays[i].textContent = newScore.toFixed(1);
                        }

                        // Average importance = (Support + Factory + Turnaround + Strategic) / 4
                        totalVal = supportImp + factoryImp + turnaroundImp + strategicImp;
                        count = 4;

                        // Total baseline (always 3 for each)
                        baselineInputs.forEach(input => totalBase += parseFloat(input.value) || 3);
                    } else if (factorType === 'DF8') {
                        // DF8: Percentage-based calculation with dynamic score (same pattern as DF6)
                        const df8Inputs = document.querySelectorAll('.df8-input');
                        let outsourcing = 0, cloud = 0, insourced = 0;
                        df8Inputs.forEach(input => {
                            const key = input.dataset.key;
                            const val = parseFloat(input.value) || 0;
                            if (key === 'outsourcing') outsourcing = val;
                            else if (key === 'cloud') cloud = val;
                            else if (key === 'insourced') insourced = val;
                        });

                        const total = outsourcing + cloud + insourced;
                        const totalPercentageDisplay = document.getElementById('totalPercentageDisplay');
                        const validationMessage = document.getElementById('validationMessage');

                        if (totalPercentageDisplay) {
                            totalPercentageDisplay.textContent = total.toFixed(2) + '%';
                        }

                        if (validationMessage) {
                            if (Math.abs(total - 100) < 0.01) {
                                validationMessage.innerHTML = '<span class="text-green-600 font-bold">✓ Valid</span>';
                            } else {
                                validationMessage.innerHTML = '<span class="text-red-600 font-bold">✗ Harus 100%</span>';
                            }
                        }

                        // Convert percentages to decimals for MMULT calculation
                        const outsourcingDec = outsourcing / 100;
                        const cloudDec = cloud / 100;
                        const insourcedDec = insourced / 100;

                        // Recalculate all item scores using MMULT formula: Score = (Outsourcing * Outsourcing%) + (Cloud * Cloud%) + (Insourced * Insourced%)
                        for (let i = 0; i < df8OutsourcingValues.length; i++) {
                            const newScore = (df8OutsourcingValues[i] * outsourcingDec) + (df8CloudValues[i] * cloudDec) + (df8InsourcedValues[i] * insourcedDec);
                            itemScores[i] = newScore;

                            // Update hidden input and display
                            if (itemScoreHiddens[i]) itemScoreHiddens[i].value = newScore.toFixed(2);
                            if (itemScoreDisplays[i]) itemScoreDisplays[i].textContent = newScore.toFixed(2);
                        }

                        // Weighted average: (Outsourcing% * 5) + (Cloud% * 3) + (Insourced% * 1) / 100
                        totalVal = (outsourcing * 5 + cloud * 3 + insourced * 1) / 100;
                        count = 1;

                        // Get baseline average
                        let outsourcingBase = 33, cloudBase = 33, insourcedBase = 34;
                        baselineInputs.forEach(input => {
                            const name = input.name;
                            if (name.includes('outsourcing')) outsourcingBase = parseFloat(input.value) || 33;
                            else if (name.includes('cloud')) cloudBase = parseFloat(input.value) || 33;
                            else if (name.includes('insourced')) insourcedBase = parseFloat(input.value) || 34;
                        });
                        totalBase = (outsourcingBase + cloudBase + insourcedBase) / 3;
                    } else if (factorType === 'DF9') {
                        // DF9: Percentage-based calculation with dynamic score (same pattern as DF6/DF8)
                        const df9Inputs = document.querySelectorAll('.df9-input');
                        let agile = 0, devops = 0, traditional = 0;
                        df9Inputs.forEach(input => {
                            const key = input.dataset.key;
                            const val = parseFloat(input.value) || 0;
                            if (key === 'agile') agile = val;
                            else if (key === 'devops') devops = val;
                            else if (key === 'traditional') traditional = val;
                        });

                        const total = agile + devops + traditional;

                        // Sync with Smart Message Box logic
                        if (typeof updateTotalDF9 === 'function') {
                            updateTotalDF9();
                        } else {
                            const df9TotalDisplay = document.getElementById('df9TotalDisplay');
                            if (df9TotalDisplay) df9TotalDisplay.textContent = total.toFixed(2);
                        }

                        // Convert percentages to decimals for MMULT calculation
                        const agileDec = agile / 100;
                        const devopsDec = devops / 100;
                        const traditionalDec = traditional / 100;

                        // Recalculate all item scores using MMULT formula: Score = (Agile * Agile%) + (DevOps * DevOps%) + (Traditional * Traditional%)
                        for (let i = 0; i < df9AgileValues.length; i++) {
                            const newScore = (df9AgileValues[i] * agileDec) + (df9DevOpsValues[i] * devopsDec) + (df9TraditionalValues[i] * traditionalDec);
                            itemScores[i] = newScore;

                            // Update hidden input and display
                            if (itemScoreHiddens[i]) itemScoreHiddens[i].value = newScore.toFixed(2);
                            if (itemScoreDisplays[i]) itemScoreDisplays[i].textContent = newScore.toFixed(2);
                        }

                        // Weighted average: (Agile% * 5) + (DevOps% * 3) + (Traditional% * 1) / 100
                        totalVal = (agile * 5 + devops * 3 + traditional * 1) / 100;
                        count = 1;

                        // Get baseline average
                        let agileBase = 15, devopsBase = 10, traditionalBase = 75;
                        baselineInputs.forEach(input => {
                            const name = input.name;
                            if (name.includes('agile')) agileBase = parseFloat(input.value) || 15;
                            else if (name.includes('devops')) devopsBase = parseFloat(input.value) || 10;
                            else if (name.includes('traditional')) traditionalBase = parseFloat(input.value) || 75;
                        });
                        totalBase = (agileBase + devopsBase + traditionalBase) / 3;
                    } else if (factorType === 'DF10') {
                        // DF10: Percentage-based calculation with dynamic score (same pattern as DF9)
                        const df10Inputs = document.querySelectorAll('.df10-input');
                        let firstMover = 0, follower = 0, slowAdopter = 0;
                        df10Inputs.forEach(input => {
                            const key = input.dataset.key;
                            const val = parseFloat(input.value) || 0;
                            if (key === 'first_mover') firstMover = val;
                            else if (key === 'follower') follower = val;
                            else if (key === 'slow_adopter') slowAdopter = val;
                        });

                        const total = firstMover + follower + slowAdopter;

                        // Sync with Smart Message Box logic
                        if (typeof updateTotalDF10 === 'function') {
                            updateTotalDF10();
                        } else {
                            const df10TotalDisplay = document.getElementById('df10TotalDisplay');
                            if (df10TotalDisplay) df10TotalDisplay.textContent = total.toFixed(2);
                        }

                        // Convert percentages to decimals for MMULT calculation
                        const firstMoverDec = firstMover / 100;
                        const followerDec = follower / 100;
                        const slowAdopterDec = slowAdopter / 100;

                        // Recalculate all item scores using MMULT formula: Score = (FirstMover * FM%) + (Follower * F%) + (SlowAdopter * SA%)
                        for (let i = 0; i < df10FirstMoverValues.length; i++) {
                            const newScore = (df10FirstMoverValues[i] * firstMoverDec) + (df10FollowerValues[i] * followerDec) + (df10SlowAdopterValues[i] * slowAdopterDec);
                            itemScores[i] = newScore;

                            // Update hidden input and display
                            if (itemScoreHiddens[i]) itemScoreHiddens[i].value = newScore.toFixed(2);
                            if (itemScoreDisplays[i]) itemScoreDisplays[i].textContent = newScore.toFixed(2);
                        }

                        // Weighted average: (FirstMover% * 5) + (Follower% * 3) + (SlowAdopter% * 1) / 100
                        totalVal = (firstMover * 5 + follower * 3 + slowAdopter * 1) / 100;
                        count = 1;

                        // Get baseline average
                        let firstMoverBase = 15, followerBase = 70, slowAdopterBase = 15;
                        baselineInputs.forEach(input => {
                            const name = input.name;
                            if (name.includes('first_mover')) firstMoverBase = parseFloat(input.value) || 15;
                            else if (name.includes('follower')) followerBase = parseFloat(input.value) || 70;
                            else if (name.includes('slow_adopter')) slowAdopterBase = parseFloat(input.value) || 15;
                        });
                        totalBase = (firstMoverBase + followerBase + slowAdopterBase) / 3;
                    } else if (factorType === 'DF4') {
                        // DF4: Call backend for MMULT calculation (requires mapping data)
                        const checkedInputs = document.querySelectorAll('.importance-input:checked');

                        // Collect inputs
                        const inputs = {};
                        checkedInputs.forEach(input => {
                            const key = input.dataset.key;
                            inputs[key] = { importance: parseFloat(input.value) || 1 };
                        });

                        // Call backend AJAX
                        fetch('{{ route("design-factors.calculate") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                factor_type: 'DF4',
                                inputs: inputs,
                                items: [] // Backend will calculate from mapping
                            })
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.items) {
                                    // Reset chart data
                                    chartData = [];
                                    chartLabels = [];

                                    // Update table with calculated results
                                    data.items.forEach((item, index) => {
                                        if (itemScoreHiddens[index]) itemScoreHiddens[index].value = item.score.toFixed(2);
                                        if (itemScoreDisplays[index]) itemScoreDisplays[index].textContent = item.score.toFixed(2);
                                        if (itemBaselineHiddens[index]) itemBaselineHiddens[index].value = item.baseline_score.toFixed(2);
                                        if (itemBaselineDisplays[index]) itemBaselineDisplays[index].textContent = item.baseline_score.toFixed(2);

                                        // Update relative importance display using data-index
                                        const relImpSpan = document.querySelector(`.relative-importance[data-index="${index}"]`);
                                        if (relImpSpan) {
                                            const relImp = parseInt(item.relative_importance);
                                            relImpSpan.textContent = (relImp > 0 ? '+' : '') + relImp;

                                            // Update color class
                                            relImpSpan.classList.remove('value-positive', 'value-negative', 'value-neutral');
                                            if (relImp > 0) relImpSpan.classList.add('value-positive');
                                            else if (relImp < 0) relImpSpan.classList.add('value-negative');
                                            else relImpSpan.classList.add('value-neutral');
                                        }

                                        // Store for chart
                                        itemScores[index] = item.score;
                                        itemBaselines[index] = item.baseline_score;

                                        // Add to chart arrays
                                        chartData.push(parseInt(item.relative_importance));
                                        chartLabels.push(item.code);
                                    });

                                    // Update charts
                                    updateCharts();
                                }

                                // Update weight display
                                if (data.weight) {
                                    const weightDisplay = document.getElementById('weightDisplay');
                                    if (weightDisplay) weightDisplay.textContent = data.weight.toFixed(6);
                                }

                                // Update average importance
                                if (data.avgImp) {
                                    const avgImpDisplay = document.getElementById('avgImpDisplay');
                                    if (avgImpDisplay) avgImpDisplay.textContent = data.avgImp.toFixed(2);
                                }
                            })
                            .catch(error => console.error('DF4 calculation error:', error));

                        return; // Skip local calculation for DF4
                    } else {
                        importanceInputs.forEach(input => {
                            totalVal += parseFloat(input.value) || 1;
                            count++;
                        });
                        // Others have baseline=3
                        baselineInputs.forEach(input => totalBase += parseFloat(input.value) || 3);
                    }

                    const avgImp = totalVal / count;
                    const avgBase = totalBase / count;

                    let weight = 1.0;
                    if (avgImp > 0 && avgBase > 0) {
                        if (['DF1', 'DF2', 'DF3', 'DF4', 'DF7'].includes(factorType)) {
                            // Strategy, Goals, Risk, Issues, and Role of IT: Importance / Baseline
                            weight = avgImp / avgBase;
                        } else if (factorType === 'DF6') {
                            // DF6: weighted importance / baseline ratio
                            weight = avgImp / (avgBase / 100 * 3);
                        } else if (factorType === 'DF8') {
                            // DF8: weighted importance / baseline ratio (same as DF6)
                            weight = avgImp / (avgBase / 100 * 3);
                        } else if (factorType === 'DF9') {
                            // DF9: weighted importance / baseline ratio (same as DF6/DF8)
                            weight = avgImp / (avgBase / 100 * 3);
                        }
                    }


                    chartData = [];
                    document.querySelectorAll('.relative-importance').forEach((display, index) => {
                        const score = itemScores[index] || 0;
                        const bScore = itemBaselines[index] || 0;
                        let relImp = 0;
                        if (bScore > 0) {
                            let calculated;
                            if (factorType === 'DF6' || factorType === 'DF8' || factorType === 'DF9' || factorType === 'DF10') {
                                // DF6, DF8, and DF9: Simple formula without weighted factor
                                // Formula: MROUND(100*Score/Baseline, 5) - 100
                                calculated = (100 * score) / bScore;
                            } else {
                                calculated = (weight * 100 * score) / bScore;
                            }
                            relImp = Math.round(calculated / 5) * 5 - 100;
                        }
                        chartData.push(relImp);
                        display.textContent = (relImp > 0 ? '+' : '') + Math.round(relImp);
                        display.className = 'relative-importance font-black text-lg ' + (relImp > 0 ? 'value-positive' : (relImp < 0 ? 'value-negative' : 'value-neutral'));
                    });

                    // Only update g            eneric charts for DF types that use them (not DF5, DF6, DF8)
                    if (!['DF5', 'DF6', 'DF8'].includes(factorType)) {
                        updateCharts();
                    }
                }

                // Validation function for max value 5
                function validateMaxValue(input) {
                    const val = parseInt(input.value) || 0;
                    const maxVal = 5;
                    const minVal = 1;

                    // Skip validation for DF6, DF8, DF9, and DF10 (uses percentage 0-100)
                    if ((factorType === 'DF6' && input.classList.contains('df6-input')) ||
                        (factorType === 'DF8' && input.classList.contains('df8-input')) ||
                        (factorType === 'DF9' && input.classList.contains('df9-input')) ||
                        (factorType === 'DF10' && input.classList.contains('df10-input'))) {
                        return;
                    }

                    if (val > maxVal) {
                        input.value = maxVal;
                        showNotification(`Nilai maksimal adalah ${maxVal}. Nilai telah diubah menjadi ${maxVal}.`, 'warning');
                    } else if (val < minVal && val !== 0) {
                        input.value = minVal;
                        showNotification(`Nilai minimal adalah ${minVal}. Nilai telah diubah menjadi ${minVal}.`, 'warning');
                    }
                }

                // Show notification function
                function showNotification(message, type = 'info') {
                    // Remove existing notification if any
                    const existingNotif = document.getElementById('inputNotification');
                    if (existingNotif) existingNotif.remove();

                    const notification = document.createElement('div');
                    notification.id = 'inputNotification';
                    notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg transition-all transform ${type === 'warning' ? 'bg-yellow-500 text-white' :
                        type === 'error' ? 'bg-red-500 text-white' :
                            'bg-blue-500 text-white'
                        }`;
                    notification.innerHTML = `
                                                                                                                                                                                                                                                                                    <div class="flex items-center gap-2">
                                                                                                                                                                                                                                                                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                                                                                                                                                                                                                                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                                                                                                                                                                                                                                                        </svg>
                                                                                                                                                                                                                                                                                        <span class="font-medium">${message}</span>
                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                `;
                    document.body.appendChild(notification);

                    // Auto remove after 3 seconds
                    setTimeout(() => {
                        notification.style.opacity = '0';
                        setTimeout(() => notification.remove(), 300);
                    }, 3000);
                }

                importanceInputs.forEach(input => {
                    input.addEventListener('input', function () {
                        validateMaxValue(this);
                        calculate();
                    });
                    input.addEventListener('change', function () {
                        calculate();
                    });
                });
                df3Inputs.forEach(input => {
                    input.addEventListener('input', function () {
                        validateMaxValue(this);
                        calculate();
                    });
                });

                // Specific logic for DF5
                if (factorType === 'DF5') {
                    const highInput = document.getElementById('importance_high');
                    const normalInput = document.getElementById('importance_normal');
                    const totalPercentageDisplay = document.getElementById('totalPercentageDisplay');
                    const validationMessage = document.getElementById('validationMessage');
                    const saveBtnMain = document.getElementById('saveBtnMain');

                    function updateSmartMessage(high, normal, total, lastTarget) {
                        const smartBox = document.getElementById('smartMessageBoxMain');
                        const smartIcon = document.getElementById('smartMessageIconMain');
                        const smartContent = document.getElementById('smartMessageContentMain');

                        if (!smartBox) return;
                        smartBox.classList.remove('hidden');

                        if (Math.abs(total - 100) < 0.01) {
                            smartBox.className = 'mb-4 p-3 rounded-lg border bg-green-50 border-green-200 text-green-800';
                            smartIcon.innerHTML = '<svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>';
                            smartContent.innerText = 'Total sudah tepat 100%. Data siap disimpan.';
                        } else if (total > 100) {
                            smartBox.className = 'mb-4 p-3 rounded-lg border bg-red-50 border-red-200 text-red-800';
                            smartIcon.innerHTML = '<svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>';
                            smartContent.innerText = `Total (${total.toFixed(2)}%) melebihi 100%! Mohon kurangi nilai agar pas 100%.`;
                        } else {
                            smartBox.className = 'mb-4 p-3 rounded-lg border bg-blue-50 border-blue-200 text-blue-800';
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

                    function updateTotalDF5(lastTarget = 'high') {
                        const high = parseFloat(highInput.value) || 0;
                        const normal = parseFloat(normalInput.value) || 0;
                        const total = high + normal;

                        if (totalPercentageDisplay) totalPercentageDisplay.textContent = total.toFixed(2) + '%';
                        updateSmartMessage(high, normal, total, lastTarget);

                        if (Math.abs(total - 100) < 0.01) {
                            if (validationMessage) validationMessage.innerHTML = '<span class="text-green-600 font-bold">✓ Valid</span>';
                            if (saveBtnMain) {
                                saveBtnMain.disabled = false;
                                saveBtnMain.classList.remove('opacity-50', 'cursor-not-allowed');
                            }
                        } else {
                            if (validationMessage) validationMessage.innerHTML = '<span class="text-red-600 font-bold">✗ Harus 100%</span>';
                            if (saveBtnMain) {
                                saveBtnMain.disabled = true;
                                saveBtnMain.classList.add('opacity-50', 'cursor-not-allowed');
                            }
                        }
                    }

                    function autoCalculateDF5() {
                        const high = parseFloat(highInput.value) || 0;
                        const normal = parseFloat(normalInput.value) || 0;

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
                                    updateDF5ResultsTable(data.results);
                                    updateDF5Charts(data.results);
                                }
                            });
                    }

                    function updateDF5ResultsTable(results) {
                        const tbody = document.querySelector('#df5ResultsTable tbody');
                        if (!tbody) return;
                        tbody.innerHTML = '';
                        results.forEach(result => {
                            const badgeClass = getBadgeClass(result.code);
                            const valClass = result.relative_importance > 0 ? 'value-positive' : (result.relative_importance < 0 ? 'value-negative' : 'value-neutral');
                            const sign = result.relative_importance > 0 ? '+' : '';
                            tbody.innerHTML += `
                                                                                                                                                                                                                                                                                <tr>
                                                                                                                                                                                                                                                                                    <td>
                                                                                                                                                                                                                                                                                        <span class="px-3 py-1 text-sm font-black rounded ${badgeClass}">${result.code}</span>
                                                                                                                                                                                                                                                                                        <span class="ml-2">${result.name}</span>
                                                                                                                                                                                                                                                                                    </td>
                                                                                                                                                                                                                                                                                    <td class="font-bold text-gray-700">${(result.score / 100).toFixed(2)}</td>
                                                                                                                                                                                                                                                                                    <td class="font-bold text-gray-700">${(result.baseline_score / 100).toFixed(2)}</td>
                                                                                                                                                                                                                                                                                    <td>
                                                                                                                                                                                                                                                                                        <span class="font-black text-lg ${valClass}">${sign}${Math.round(result.relative_importance)}</span>
                                                                                                                                                                                                                                                                                    </td>
                                                                                                                                                                                                                                                                                </tr>
                                                                                                                                                                                                                                                                            `;
                        });
                    }

                    function updateDF5Charts(results) {
                        if (!df5BarChart || !df5RadarChart) return;
                        const data = results.map(r => r.relative_importance);
                        df5BarChart.data.datasets[0].data = data;
                        df5BarChart.data.datasets[0].backgroundColor = data.map(v => v >= 0 ? 'rgba(79, 124, 53, 0.7)' : 'rgba(192, 0, 0, 0.7)');
                        df5BarChart.data.datasets[0].borderColor = data.map(v => v >= 0 ? 'rgba(79, 124, 53, 1)' : 'rgba(192, 0, 0, 1)');
                        df5BarChart.update('none');
                        df5RadarChart.data.datasets[0].data = data.map(v => v + 100);
                        df5RadarChart.update('none');
                    }

                    function getBadgeClass(code) {
                        if (code.startsWith('EDM')) return 'badge-edm';
                        if (code.startsWith('APO')) return 'badge-apo';
                        if (code.startsWith('BAI')) return 'badge-bai';
                        if (code.startsWith('DSS')) return 'badge-dss';
                        if (code.startsWith('MEA')) return 'badge-mea';
                        return '';
                    }

                    highInput.addEventListener('input', () => { updateTotalDF5('high'); autoCalculateDF5(); });
                    normalInput.addEventListener('input', () => { updateTotalDF5('normal'); autoCalculateDF5(); });
                }

                // Specific logic for DF6
                if (factorType === 'DF6') {
                    const highInput = document.getElementById('importance_high');
                    const normalInput = document.getElementById('importance_normal');
                    const lowInput = document.getElementById('importance_low');
                    const totalPercentageDisplay = document.getElementById('totalPercentageDisplay');
                    const validationMessage = document.getElementById('validationMessage');
                    const saveBtnMain = document.getElementById('saveBtnMain');

                    function updateSmartMessageDF6(high, normal, low, total, lastTarget) {
                        const smartBox = document.getElementById('smartMessageBoxMain');
                        const smartIcon = document.getElementById('smartMessageIconMain');
                        const smartContent = document.getElementById('smartMessageContentMain');

                        if (!smartBox) return;
                        smartBox.classList.remove('hidden');

                        if (Math.abs(total - 100) < 0.01) {
                            smartBox.className = 'mb-4 p-3 rounded-lg border bg-green-50 border-green-200 text-green-800';
                            smartIcon.innerHTML = '<svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>';
                            smartContent.innerText = 'Total sudah tepat 100%. Data siap disimpan.';
                        } else if (total > 100) {
                            smartBox.className = 'mb-4 p-3 rounded-lg border bg-red-50 border-red-200 text-red-800';
                            smartIcon.innerHTML = '<svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>';
                            smartContent.innerText = `Total (${total.toFixed(2)}%) melebihi 100%! Mohon kurangi nilai agar pas 100%.`;
                        } else {
                            smartBox.className = 'mb-4 p-3 rounded-lg border bg-blue-50 border-blue-200 text-blue-800';
                            smartIcon.innerHTML = '<svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>';

                            const remaining = 100 - total;
                            smartContent.innerText = `Total saat ini ${total.toFixed(2)}%. Masih kurang ${remaining.toFixed(2)}% untuk mencapai 100%.`;
                        }
                    }

                    function updateTotalDF6(lastTarget = 'high') {
                        const high = parseFloat(highInput.value) || 0;
                        const normal = parseFloat(normalInput.value) || 0;
                        const low = parseFloat(lowInput.value) || 0;
                        const total = high + normal + low;

                        if (totalPercentageDisplay) totalPercentageDisplay.textContent = total.toFixed(2) + '%';

                        if (validationMessage) {
                            if (Math.abs(total - 100) < 0.01) {
                                validationMessage.innerHTML = '<span class="validation-success">✓ Valid</span>';
                            } else {
                                validationMessage.innerHTML = '<span class="validation-error">✗ Harus 100%</span>';
                            }
                        }

                        updateSmartMessageDF6(high, normal, low, total, lastTarget);
                        calculate();
                    }

                    function autoCalculateDF6() {
                        const high = parseFloat(highInput.value) || 0;
                        const normal = parseFloat(normalInput.value) || 0;
                        const low = parseFloat(lowInput.value) || 0;

                        console.log('DF6 autoCalculate called with:', { high, normal, low });

                        fetch('{{ route('design-factors.df6.calculate') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                importance_high: high,
                                importance_normal: normal,
                                importance_low: low
                            })
                        })
                            .then(response => {
                                console.log('DF6 response status:', response.status);
                                return response.json();
                            })
                            .then(data => {
                                console.log('DF6 calculation data received:', data);
                                if (data.success) {
                                    console.log('Updating DF6 results table with', data.results.length, 'items');
                                    updateDF6ResultsTable(data.results);
                                    updateDF6Charts(data.results);
                                } else {
                                    console.error('DF6 calculation failed:', data);
                                }
                            })
                            .catch(error => {
                                console.error('DF6 AJAX error:', error);
                            });
                    }

                    function updateDF6ResultsTable(results) {
                        const tbody = document.querySelector('#df6ResultsTable tbody');
                        if (!tbody) return;
                        tbody.innerHTML = '';
                        results.forEach(result => {
                            const badgeClass = getBadgeClass(result.code);
                            const valClass = result.relative_importance > 0 ? 'value-positive' : (result.relative_importance < 0 ? 'value-negative' : 'value-neutral');
                            const sign = result.relative_importance > 0 ? '+' : '';
                            tbody.innerHTML += `
                                                                                                                                                                                                                                            <tr>
                                                                                                                                                                                                                                                <td>
                                                                                                                                                                                                                                                    <span class="px-3 py-1 text-sm font-black rounded ${badgeClass}">${result.code}</span>
                                                                                                                                                                                                                                                    <span class="ml-2">${result.name}</span>
                                                                                                                                                                                                                                                </td>
                                                                                                                                                                                                                                                <td class="font-bold text-gray-700">${(result.score / 100).toFixed(2)}</td>
                                                                                                                                                                                                                                                <td class="font-bold text-gray-700">${(result.baseline_score / 100).toFixed(2)}</td>
                                                                                                                                                                                                                                                <td>
                                                                                                                                                                                                                                                    <span class="relative-importance font-black text-lg ${valClass}">
                                                                                                                                                                                                                                                        ${sign}${Math.round(result.relative_importance)}
                                                                                                                                                                                                                                                    </span>
                                                                                                                                                                                                                                                </td>
                                                                                                                                                                                                                                            </tr>
                                                                                                                                                                                                                                        `;
                        });
                    }

                    function updateDF6Charts(results) {
                        const labels = results.map(r => r.code);
                        const data = results.map(r => r.relative_importance);

                        if (df6BarChart) {
                            df6BarChart.data.labels = labels;
                            df6BarChart.data.datasets[0].data = data;
                            df6BarChart.data.datasets[0].backgroundColor = data.map(v => v >= 0 ? 'rgba(79, 124, 53, 0.7)' : 'rgba(192, 0, 0, 0.7)');
                            df6BarChart.data.datasets[0].borderColor = data.map(v => v >= 0 ? 'rgba(79, 124, 53, 1)' : 'rgba(192, 0, 0, 1)');
                            df6BarChart.update();
                        }

                        if (df6RadarChart) {
                            df6RadarChart.data.labels = labels;
                            df6RadarChart.data.datasets[0].data = data.map(v => v + 100);
                            df6RadarChart.update();
                        }
                    }

                    function getBadgeClass(code) {
                        if (code.startsWith('EDM')) return 'badge-edm';
                        if (code.startsWith('APO')) return 'badge-apo';
                        if (code.startsWith('BAI')) return 'badge-bai';
                        if (code.startsWith('DSS')) return 'badge-dss';
                        if (code.startsWith('MEA')) return 'badge-mea';
                        return '';
                    }

                    highInput.addEventListener('input', () => { updateTotalDF6('high'); autoCalculateDF6(); });
                    normalInput.addEventListener('input', () => { updateTotalDF6('normal'); autoCalculateDF6(); });
                    lowInput.addEventListener('input', () => { updateTotalDF6('low'); autoCalculateDF6(); });
                }

                // Specific logic for DF8
                if (factorType === 'DF8') {
                    const outsourcingInput = document.getElementById('importance_outsourcing');
                    const cloudInput = document.getElementById('importance_cloud');
                    const insourcedInput = document.getElementById('importance_insourced');
                    const totalPercentageDisplay = document.getElementById('totalPercentageDisplay');
                    const validationMessage = document.getElementById('validationMessage');
                    const saveBtnMain = document.getElementById('saveBtnMain');

                    function updateSmartMessageDF8(outsourcing, cloud, insourced, total, lastTarget) {
                        const smartBox = document.getElementById('smartMessageBoxDF8');
                        const smartIcon = document.getElementById('smartMessageIconDF8');
                        const smartContent = document.getElementById('smartMessageContentDF8');

                        if (!smartBox) return;
                        smartBox.classList.remove('hidden');

                        if (Math.abs(total - 100) < 0.01) {
                            smartBox.className = 'mb-4 p-3 rounded-lg border bg-green-50 border-green-200 text-green-800';
                            smartIcon.innerHTML = '<svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>';
                            smartContent.innerHTML = `Total sudah tepat 100%. Data siap disimpan. Total saat ini: <strong>100%</strong>.`;
                        } else if (total > 100) {
                            smartBox.className = 'mb-4 p-3 rounded-lg border bg-red-50 border-red-200 text-red-800';
                            smartIcon.innerHTML = '<svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>';
                            smartContent.innerHTML = `Nilai harus 100%, tidak boleh kurang atau lebih! Total saat ini <strong>${total.toFixed(2)}%</strong> (Kelebihan ${(total - 100).toFixed(2)}%).`;
                        } else {
                            smartBox.className = 'mb-4 p-3 rounded-lg border bg-red-50 border-red-200 text-red-800';
                            smartIcon.innerHTML = '<svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>';

                            const remaining = 100 - total;
                            smartContent.innerHTML = `Nilai harus 100%, tidak boleh kurang atau lebih! Total saat ini <strong>${total.toFixed(2)}%</strong> (Kurang ${remaining.toFixed(2)}% lagi yang harus diisi).`;
                        }
                    }

                    function updateTotalDF8(lastTarget = 'outsourcing') {
                        const outsourcing = parseFloat(outsourcingInput.value) || 0;
                        const cloud = parseFloat(cloudInput.value) || 0;
                        const insourced = parseFloat(insourcedInput.value) || 0;
                        const total = outsourcing + cloud + insourced;

                        if (totalPercentageDisplay) totalPercentageDisplay.textContent = total.toFixed(2) + '%';

                        if (validationMessage) {
                            if (Math.abs(total - 100) < 0.01) {
                                validationMessage.innerHTML = '<span class="text-green-600 font-bold">✓ Valid</span>';
                                if (saveBtnMain) {
                                    saveBtnMain.disabled = false;
                                    saveBtnMain.classList.remove('opacity-50', 'cursor-not-allowed');
                                }
                            } else {
                                validationMessage.innerHTML = '<span class="text-red-600 font-bold">✗ Harus 100%</span>';
                                if (saveBtnMain) {
                                    saveBtnMain.disabled = true;
                                    saveBtnMain.classList.add('opacity-50', 'cursor-not-allowed');
                                }
                            }
                        }

                        updateSmartMessageDF8(outsourcing, cloud, insourced, total, lastTarget);
                    }

                    function autoCalculateDF8() {
                        const outsourcing = parseFloat(outsourcingInput.value) || 0;
                        const cloud = parseFloat(cloudInput.value) || 0;
                        const insourced = parseFloat(insourcedInput.value) || 0;

                        fetch('{{ route('design-factors.df8.calculate') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                importance_outsourcing: outsourcing,
                                importance_cloud: cloud,
                                importance_insourced: insourced
                            })
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    updateDF8ResultsTable(data.results);
                                    updateDF8Charts(data.results);
                                }
                            });
                    }

                    function updateDF8ResultsTable(results) {
                        const tbody = document.querySelector('#df8ResultsTable tbody');
                        if (!tbody) return;
                        tbody.innerHTML = '';
                        results.forEach((result, index) => {
                            const badgeClass = getBadgeClass(result.code);
                            const valClass = result.relative_importance > 0 ? 'value-positive' : (result.relative_importance < 0 ? 'value-negative' : 'value-neutral');
                            const sign = result.relative_importance > 0 ? '+' : '';

                            // Look up mapping values from existing hidden inputs if possible, or use 1 as default
                            // In a real application, you might want these passed from the server in the AJAX response
                            const outVal = document.querySelector(`.item-outsourcing-value[data-code="${result.code}"]`)?.value || 1;
                            const cloudVal = document.querySelector(`.item-cloud-value[data-code="${result.code}"]`)?.value || 1;
                            const insVal = document.querySelector(`.item-insourced-value[data-code="${result.code}"]`)?.value || 1;

                            tbody.innerHTML += `
                                                                                                                                                                                                                                            <tr>
                                                                                                                                                                                                                                                <td>
                                                                                                                                                                                                                                                    <span class="px-3 py-1 text-sm font-black rounded ${badgeClass}">${result.code}</span>
                                                                                                                                                                                                                                                    <input type="hidden" name="items[${index}][code]" value="${result.code}">
                                                                                                                                                                                                                                                    <input type="hidden" name="items[${index}][score]" value="${result.score}" class="item-score-hidden">
                                                                                                                                                                                                                                                    <input type="hidden" name="items[${index}][baseline_score]" value="${result.baseline_score}" class="item-baseline-hidden">

                                                                                                                                                                                                                                                    <input type="hidden" class="item-outsourcing-value" value="${outVal}" data-code="${result.code}">
                                                                                                                                                                                                                                                    <input type="hidden" class="item-cloud-value" value="${cloudVal}" data-code="${result.code}">
                                                                                                                                                                                                                                                    <input type="hidden" class="item-insourced-value" value="${insVal}" data-code="${result.code}">

                                                                                                                                                                                                                                                    <span class="ml-2">${result.name}</span>
                                                                                                                                                                                                                                                </td>
                                                                                                                                                                                                                                                <td class="font-bold text-gray-700 item-score-display">${(result.score).toFixed(1)}</td>
                                                                                                                                                                                                                                                <td class="font-bold text-gray-700 item-baseline-display">${(result.baseline_score).toFixed(2)}</td>
                                                                                                                                                                                                                                                <td>
                                                                                                                                                                                                                                                    <span class="relative-importance font-black text-lg ${valClass}">
                                                                                                                                                                                                                                                        ${sign}${Math.round(result.relative_importance)}
                                                                                                                                                                                                                                                    </span>
                                                                                                                                                                                                                                                </td>
                                                                                                                                                                                                                                            </tr>
                                                                                                                                                                                                                                        `;
                        });
                    }

                    function updateDF8Charts(results) {
                        const labels = results.map(r => r.code);
                        const data = results.map(r => r.relative_importance);

                        if (df8BarChart) {
                            df8BarChart.data.labels = labels;
                            df8BarChart.data.datasets[0].data = data;
                            df8BarChart.data.datasets[0].backgroundColor = data.map(v => v >= 0 ? 'rgba(79, 124, 53, 0.7)' : 'rgba(192, 0, 0, 0.7)');
                            df8BarChart.data.datasets[0].borderColor = data.map(v => v >= 0 ? 'rgba(79, 124, 53, 1)' : 'rgba(192, 0, 0, 1)');
                            df8BarChart.update();
                        }

                        if (df8RadarChart) {
                            df8RadarChart.data.labels = labels;
                            df8RadarChart.data.datasets[0].data = data.map(v => v + 100);
                            df8RadarChart.update();
                        }
                    }

                    function getBadgeClass(code) {
                        if (code.startsWith('EDM')) return 'badge-edm';
                        if (code.startsWith('APO')) return 'badge-apo';
                        if (code.startsWith('BAI')) return 'badge-bai';
                        if (code.startsWith('DSS')) return 'badge-dss';
                        if (code.startsWith('MEA')) return 'badge-mea';
                        return '';
                    }

                    outsourcingInput.addEventListener('input', () => { updateTotalDF8('outsourcing'); autoCalculateDF8(); });
                    cloudInput.addEventListener('input', () => { updateTotalDF8('cloud'); autoCalculateDF8(); });
                    insourcedInput.addEventListener('input', () => { updateTotalDF8('insourced'); autoCalculateDF8(); });
                }

                // Specific logic for DF9
                if (factorType === 'DF9') {
                    const agileInput = document.getElementById('importance_agile');
                    const devopsInput = document.getElementById('importance_devops');
                    const traditionalInput = document.getElementById('importance_traditional');
                    const totalDisplay = document.getElementById('df9TotalDisplay');
                    const saveBtnMain = document.getElementById('saveBtnMain');

                    function updateSmartMessageDF9(agile, devops, traditional, total) {
                        const smartBox = document.getElementById('df9SmartMessageBox');
                        const smartIcon = document.getElementById('df9SmartIcon');
                        const smartContent = document.getElementById('df9SmartContent');

                        if (!smartBox) return;

                        if (Math.abs(total - 100) < 0.01) {
                            smartBox.className = 'mb-4 p-3 rounded-lg border bg-green-50 border-green-200 text-green-800';
                            smartIcon.innerHTML = '<svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>';
                            smartContent.innerHTML = `Total sudah tepat 100%. Data siap disimpan. Total saat ini: <span id="df9TotalDisplay">100</span>%.`;
                        } else if (total > 100) {
                            smartBox.className = 'mb-4 p-3 rounded-lg border bg-red-50 border-red-200 text-red-800';
                            smartIcon.innerHTML = '<svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>';
                            smartContent.innerHTML = `Nilai harus 100%, tidak boleh kurang atau lebih! Total saat ini ${total.toFixed(2)}% (Kelebihan ${(total - 100).toFixed(2)}%).`;
                        } else {
                            smartBox.className = 'mb-4 p-3 rounded-lg border bg-red-50 border-red-200 text-red-800';
                            smartIcon.innerHTML = '<svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>';
                            const remaining = 100 - total;
                            smartContent.innerHTML = `Nilai harus 100%, tidak boleh kurang atau lebih! Total saat ini <strong>${total.toFixed(2)}%</strong> (Kurang ${remaining.toFixed(2)}% lagi yang harus diisi).`;
                        }
                    }

                    function updateTotalDF9() {
                        const agile = parseFloat(agileInput.value) || 0;
                        const devops = parseFloat(devopsInput.value) || 0;
                        const traditional = parseFloat(traditionalInput.value) || 0;
                        const total = agile + devops + traditional;

                        if (Math.abs(total - 100) < 0.01) {
                            if (saveBtnMain) {
                                saveBtnMain.disabled = false;
                                saveBtnMain.classList.remove('opacity-50', 'cursor-not-allowed');
                            }
                        } else {
                            if (saveBtnMain) {
                                saveBtnMain.disabled = true;
                                saveBtnMain.classList.add('opacity-50', 'cursor-not-allowed');
                            }
                        }

                        updateSmartMessageDF9(agile, devops, traditional, total);
                    }

                    function autoCalculateDF9() {
                        const agile = parseFloat(agileInput.value) || 0;
                        const devops = parseFloat(devopsInput.value) || 0;
                        const traditional = parseFloat(traditionalInput.value) || 0;

                        fetch('{{ route('design-factors.df9.calculate') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                importance_agile: agile,
                                importance_devops: devops,
                                importance_traditional: traditional
                            })
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    updateDF9ResultsTable(data.results);
                                    if (window.df9BarChart) updateDF9Charts(data.results);
                                    else calculate(); // Fallback to global calculate if charts not ready
                                }
                            });
                    }

                    function updateDF9ResultsTable(results) {
                        const tbody = document.querySelector('#df9ResultsTable tbody');
                        if (!tbody) return;

                        // We need to match results to existing rows or rebuild them
                        // Rebuilding is safer to ensure order
                        tbody.innerHTML = '';

                        results.forEach((result, idx) => {
                            const badgeClass = result.code.startsWith('EDM') ? 'badge-edm' :
                                (result.code.startsWith('APO') ? 'badge-apo' :
                                    (result.code.startsWith('BAI') ? 'badge-bai' :
                                        (result.code.startsWith('DSS') ? 'badge-dss' : 'badge-mea')));

                            const valClass = result.relative_importance > 0 ? 'value-positive' :
                                (result.relative_importance < 0 ? 'value-negative' : 'value-neutral');
                            const sign = result.relative_importance > 0 ? '+' : '';

                            // Get hidden values for next calculation round (preserve inputs)
                            // Note: In a complete implementation we'd fetch these or cache them
                            // For now we assume they are unused for display, or we can look them up

                            tbody.innerHTML += `
                                                                                                            <tr>
                                                                                                                <td>
                                                                                                                    <span class="px-3 py-1 text-sm font-black rounded ${badgeClass}">${result.code}</span>
                                                                                                                    <input type="hidden" name="items[${idx}][code]" value="${result.code}">
                                                                                                                    <input type="hidden" name="items[${idx}][score]" value="${result.score}">
                                                                                                                    <input type="hidden" name="items[${idx}][baseline_score]" value="${result.baseline_score}">
                                                                                                                    <span class="ml-2">${result.name}</span>
                                                                                                                </td>
                                                                                                                <td class="font-bold text-gray-700 item-score-display">${result.score.toFixed(2)}</td>
                                                                                                                <td class="font-bold text-gray-700 item-baseline-display">${result.baseline_score.toFixed(2)}</td>
                                                                                                                <td>
                                                                                                                    <span class="relative-importance font-black text-lg ${valClass}">
                                                                                                                        ${sign}${Math.round(result.relative_importance)}
                                                                                                                    </span>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                         `;
                        });
                    }

                    function updateDF9Charts(results) {
                        const labels = results.map(r => r.code);
                        const data = results.map(r => r.relative_importance);

                        if (df9BarChart) {
                            df9BarChart.data.labels = labels;
                            df9BarChart.data.datasets[0].data = data;
                            df9BarChart.data.datasets[0].backgroundColor = data.map(v => v >= 0 ? 'rgba(79, 124, 53, 0.7)' : 'rgba(192, 0, 0, 0.7)');
                            df9BarChart.data.datasets[0].borderColor = data.map(v => v >= 0 ? 'rgba(79, 124, 53, 1)' : 'rgba(192, 0, 0, 1)');
                            df9BarChart.update();
                        }

                        if (df9RadarChart) {
                            df9RadarChart.data.labels = labels;
                            df9RadarChart.data.datasets[0].data = data.map(v => v + 100);
                            df9RadarChart.update();
                        }
                    }

                    agileInput.addEventListener('input', () => { updateTotalDF9(); autoCalculateDF9(); });
                    devopsInput.addEventListener('input', () => { updateTotalDF9(); autoCalculateDF9(); });
                    traditionalInput.addEventListener('input', () => { updateTotalDF9(); autoCalculateDF9(); });
                }

                // Specific logic for DF10
                if (factorType === 'DF10') {
                    const firstMoverInput = document.getElementById('importance_first_mover');
                    const followerInput = document.getElementById('importance_follower');
                    const slowAdopterInput = document.getElementById('importance_slow_adopter');
                    const totalDisplay = document.getElementById('df10TotalDisplay');
                    const saveBtnMain = document.getElementById('saveBtnMain');

                    function updateSmartMessageDF10(fm, f, sa, total) {
                        const smartBox = document.getElementById('df10SmartMessageBox');
                        const smartIcon = document.getElementById('df10SmartIcon');
                        const smartContent = document.getElementById('df10SmartContent');

                        if (!smartBox) return;

                        if (Math.abs(total - 100) < 0.01) {
                            smartBox.className = 'mb-4 p-3 rounded-lg border bg-green-50 border-green-200 text-green-800';
                            smartIcon.innerHTML = '<svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>';
                            smartContent.innerHTML = `Total sudah tepat 100%. Data siap disimpan. Total saat ini: <span id="df10TotalDisplay">100</span>%.`;
                        } else if (total > 100) {
                            smartBox.className = 'mb-4 p-3 rounded-lg border bg-red-50 border-red-200 text-red-800';
                            smartIcon.innerHTML = '<svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>';
                            smartContent.innerHTML = `Nilai harus 100%, tidak boleh kurang atau lebih! Total saat ini ${total.toFixed(2)}% (Kelebihan ${(total - 100).toFixed(2)}%).`;
                        } else {
                            smartBox.className = 'mb-4 p-3 rounded-lg border bg-red-50 border-red-200 text-red-800';
                            smartIcon.innerHTML = '<svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>';
                            const remaining = 100 - total;
                            smartContent.innerHTML = `Nilai harus 100%, tidak boleh kurang atau lebih! Total saat ini <strong>${total.toFixed(2)}%</strong> (Kurang ${remaining.toFixed(2)}% lagi yang harus diisi).`;
                        }
                    }

                    function updateTotalDF10() {
                        const fm = parseFloat(firstMoverInput.value) || 0;
                        const f = parseFloat(followerInput.value) || 0;
                        const sa = parseFloat(slowAdopterInput.value) || 0;
                        const total = fm + f + sa;

                        if (Math.abs(total - 100) < 0.01) {
                            if (saveBtnMain) {
                                saveBtnMain.disabled = false;
                                saveBtnMain.classList.remove('opacity-50', 'cursor-not-allowed');
                            }
                        } else {
                            if (saveBtnMain) {
                                saveBtnMain.disabled = true;
                                saveBtnMain.classList.add('opacity-50', 'cursor-not-allowed');
                            }
                        }

                        updateSmartMessageDF10(fm, f, sa, total);
                    }

                    function updateDF10Charts(results) {
                        const labels = results.map(r => r.code);
                        const data = results.map(r => r.relative_importance);

                        if (df10BarChart) {
                            df10BarChart.data.labels = labels;
                            df10BarChart.data.datasets[0].data = data;
                            df10BarChart.data.datasets[0].backgroundColor = data.map(v => v >= 0 ? 'rgba(79, 124, 53, 0.7)' : 'rgba(192, 0, 0, 0.7)');
                            df10BarChart.data.datasets[0].borderColor = data.map(v => v >= 0 ? 'rgba(79, 124, 53, 1)' : 'rgba(192, 0, 0, 1)');
                            df10BarChart.update();
                        }

                        if (df10RadarChart) {
                            df10RadarChart.data.labels = labels;
                            df10RadarChart.data.datasets[0].data = data.map(v => v + 100);
                            df10RadarChart.update();
                        }
                    }

                    function autoCalculateDF10() {
                        const fm = parseFloat(firstMoverInput.value) || 0;
                        const f = parseFloat(followerInput.value) || 0;
                        const sa = parseFloat(slowAdopterInput.value) || 0;

                        fetch('{{ route('design-factors.df10.calculate') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                importance_first_mover: fm,
                                importance_follower: f,
                                importance_slow_adopter: sa
                            })
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    updateDF10ResultsTable(data.results);
                                    if (window.df10BarChart) updateDF10Charts(data.results);
                                    else calculate(); // Fallback
                                }
                            });
                    }

                    function updateDF10ResultsTable(results) {
                        const table = document.querySelector('.clean-table');
                        if (!table) return;
                        const rows = table.querySelectorAll('tbody tr');
                        results.forEach((result, idx) => {
                            const row = rows[idx];
                            if (row) {
                                const scoreDisplay = row.querySelector('.item-score-display');
                                const baseDisplay = row.querySelector('.item-baseline-display');
                                const relImp = row.querySelector('.relative-importance');

                                if (scoreDisplay) scoreDisplay.textContent = result.score.toFixed(2);
                                if (baseDisplay) baseDisplay.textContent = result.baseline_score.toFixed(2);
                                if (relImp) {
                                    relImp.textContent = (result.relative_importance > 0 ? '+' : '') + Math.round(result.relative_importance);
                                    relImp.className = 'relative-importance font-black text-lg ' +
                                        (result.relative_importance > 0 ? 'value-positive' :
                                            (result.relative_importance < 0 ? 'value-negative' : 'value-neutral'));
                                }
                            }
                        });
                    }

                    firstMoverInput.addEventListener('input', () => { updateTotalDF10(); autoCalculateDF10(); });
                    followerInput.addEventListener('input', () => { updateTotalDF10(); autoCalculateDF10(); });
                    slowAdopterInput.addEventListener('input', () => { updateTotalDF10(); autoCalculateDF10(); });
                }

                initCharts();
                calculate();

                // Initial DF5 update if applicable
                if (factorType === 'DF5') {
                    updateTotalDF5();
                }

                // Initial DF6 update if applicable
                if (factorType === 'DF6') {
                    updateTotalDF6();
                    autoCalculateDF6();
                }

                // Initial DF8 update if applicable
                if (factorType === 'DF8') {
                    updateTotalDF8();
                    autoCalculateDF8();
                }

                // Initial DF9 update if applicable
                if (factorType === 'DF9') {
                    updateTotalDF9();
                    autoCalculateDF9();
                }

                // Initial DF10 update if applicable
                if (factorType === 'DF10') {
                    updateTotalDF10();
                    autoCalculateDF10();
                }
            });

            // Reset All Button Event Listener
            const resetAllBtn = document.getElementById('resetAllBtn');
            console.log('Reset button element:', resetAllBtn);

            if (resetAllBtn) {
                console.log('Attaching click event to reset button');
                resetAllBtn.addEventListener('click', function () {
                    console.log('Reset button clicked!');
                    Swal.fire({
                        title: 'Reset Semua Design Factor?',
                        text: "Seluruh data DF1 hingga DF10 akan dihapus secara permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Reset Semua!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            console.log('User confirmed reset');
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = '{{ route('design-factors.reset-all') }}';

                            const csrfToken = document.createElement('input');
                            csrfToken.type = 'hidden';
                            csrfToken.name = '_token';
                            csrfToken.value = '{{ csrf_token() }}';
                            form.appendChild(csrfToken);

                            document.body.appendChild(form);
                            form.submit();
                        } else {
                            console.log('User cancelled reset');
                        }
                    });
                });
            } else {
                console.error('Reset button not found! Button might be hidden or not rendered.');
            }
        </script>
    @endpush
</x-app-layout>