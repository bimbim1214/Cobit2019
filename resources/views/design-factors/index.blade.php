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

            <!-- Design Factor Tabs -->
            <div class="flex flex-wrap justify-center gap-2 mb-8">
                <a href="{{ route('design-factors.index', 'DF1') }}"
                    class="px-6 py-2 text-sm font-bold rounded-full transition-all {{ $type === 'DF1' ? 'bg-green-600 text-white shadow-lg' : 'bg-white text-gray-600 hover:bg-gray-200' }}">
                    DF1: Enterprise Strategy
                </a>
                <a href="{{ route('design-factors.index', 'DF2') }}"
                    class="px-6 py-2 text-sm font-bold rounded-full transition-all {{ $type === 'DF2' ? 'bg-green-600 text-white shadow-lg' : 'bg-white text-gray-600 hover:bg-gray-200' }}">
                    DF2: Enterprise Goals
                </a>

                <a href="{{ route('design-factors.index', 'DF3') }}"
                    class="px-6 py-2 text-sm font-bold rounded-full transition-all {{ $type === 'DF3' ? 'bg-green-600 text-white shadow-lg' : 'bg-white text-gray-600 hover:bg-gray-200' }}">
                    DF3: Risk Profile
                </a>

                <a href="{{ route('design-factors.index', 'DF4') }}"
                    class="px-6 py-2 text-sm font-bold rounded-full transition-all {{ $type === 'DF4' ? 'bg-green-600 text-white shadow-lg' : 'bg-white text-gray-600 hover:bg-gray-200' }}">
                    DF4: IT-Related Issues
                </a>

                <a href="{{ route('design-factors.index', 'DF6') }}"
                    class="px-6 py-2 text-sm font-bold rounded-full transition-all {{ $type === 'DF6' ? 'bg-green-600 text-white shadow-lg' : 'bg-white text-gray-600 hover:bg-gray-200' }}">
                    DF6: Threat Landscape
                </a>

                <a href="{{ route('design-factors.index', 'DF7') }}"
                    class="px-6 py-2 text-sm font-bold rounded-full transition-all {{ $type === 'DF7' ? 'bg-green-600 text-white shadow-lg' : 'bg-white text-gray-600 hover:bg-gray-200' }}">
                    DF7: Importance of Role of IT
                </a>

                <a href="{{ route('design-factors.index', 'DF8') }}"
                    class="px-6 py-2 text-sm font-bold rounded-full transition-all {{ $type === 'DF8' ? 'bg-green-600 text-white shadow-lg' : 'bg-white text-gray-600 hover:bg-gray-200' }}">
                    DF8: Sourcing Model
                </a>

                <a href="{{ route('design-factors.index', 'DF9') }}"
                    class="px-6 py-2 text-sm font-bold rounded-full transition-all {{ $type === 'DF9' ? 'bg-green-600 text-white shadow-lg' : 'bg-white text-gray-600 hover:bg-gray-200' }}">
                    DF9: IT Implementation
                </a>

                <a href="{{ route('design-factors.index', 'DF10') }}"
                    class="px-6 py-2 text-sm font-bold rounded-full transition-all {{ $type === 'DF10' ? 'bg-green-600 text-white shadow-lg' : 'bg-white text-gray-600 hover:bg-gray-200' }}">
                    DF10: Tech Adoption
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
                            @elseif($type === 'DF6')
                                Threat Landscape
                            @elseif($type === 'DF7')
                                Importance of Role of IT
                            @elseif($type === 'DF8')
                                Importance of Sourcing Model
                            @elseif($type === 'DF9')
                                Importance of IT Implementation
                            @elseif($type === 'DF10')
                                Technology Adoption Strategy
                            @endif
                        </h2>
                    </div>
                    <div class="p-4 bg-white">
                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                            <!-- Table container -->
                            <div class="lg:col-span-9 xl:col-span-10 overflow-x-auto min-w-0">
                                <table
                                    class="{{ in_array($type, ['DF1', 'DF2', 'DF6', 'DF7', 'DF8', 'DF10']) ? 'strategic-table' : 'clean-table' }}">
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
                                                <th style="min-width: 200px;">Importance (100%)</th></th>
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
                                                            data-key="{{ $key }}">
                                                    </td>
                                                    <td class="p-0">
                                                        <input type="number" name="inputs[{{ $key }}][likelihood]"
                                                            value="{{ data_get($designFactor->inputs, $key . '.likelihood', 3) }}"
                                                            min="1" max="5" class="heat-input df3-input likelihood-input"
                                                            data-key="{{ $key }}">
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
                                                                    data-key="{{ $key }}" {{ $currentImportance == 1 ? 'checked' : '' }}>
                                                            </label>
                                                            <label class="flex flex-col items-center cursor-pointer">
                                                                <input type="radio" name="inputs[{{ $key }}][importance]"
                                                                    value="2"
                                                                    class="importance-icon-radio yellow importance-input"
                                                                    data-key="{{ $key }}" {{ $currentImportance == 2 ? 'checked' : '' }}>
                                                            </label>
                                                            <label class="flex flex-col items-center cursor-pointer">
                                                                <input type="radio" name="inputs[{{ $key }}][importance]"
                                                                    value="3" class="importance-icon-radio red importance-input"
                                                                    data-key="{{ $key }}" {{ $currentImportance == 3 ? 'checked' : '' }}>
                                                            </label>
                                                        </div>
                                                    </td>
                                                @elseif($type === 'DF6')
                                                    <td class="importance-cell">
                                                        <div class="flex items-center justify-center gap-1">
                                                            <input type="number" name="inputs[{{ $key }}][importance]"
                                                                value="{{ data_get($designFactor->inputs, $key . '.importance', ($key === 'high' ? 25 : ($key === 'normal' ? 75 : 0))) }}"
                                                                min="0" max="100"
                                                                class="w-20 px-2 py-1 text-center font-extrabold bg-white border border-gray-300 rounded focus:outline-none focus:border-green-500 importance-input df6-input"
                                                                data-key="{{ $key }}">
                                                            <span class="font-bold text-gray-600">%</span>
                                                        </div>
                                                    </td>
                                                @elseif($type === 'DF8')
                                                    <td class="importance-cell">
                                                        <div class="flex items-center justify-center gap-1">
                                                            <input type="number" name="inputs[{{ $key }}][importance]"
                                                                value="{{ data_get($designFactor->inputs, $key . '.importance', ($key === 'outsourcing' ? 10 : ($key === 'cloud' ? 50 : 40))) }}"
                                                                min="0" max="100"
                                                                class="w-20 px-2 py-1 text-center font-extrabold bg-white border border-gray-300 rounded focus:outline-none focus:border-green-500 importance-input df8-input"
                                                                data-key="{{ $key }}">
                                                            <span class="font-bold text-gray-600">%</span>
                                                        </div>
                                                    </td>
                                                @elseif($type === 'DF9')
                                                    <td class="importance-cell">
                                                        <div class="flex items-center justify-center gap-1">
                                                            <input type="number" name="inputs[{{ $key }}][importance]"
                                                                value="{{ data_get($designFactor->inputs, $key . '.importance', ($key === 'agile' ? 50 : ($key === 'devops' ? 10 : 40))) }}"
                                                                min="0" max="100"
                                                                class="w-20 px-2 py-1 text-center font-extrabold bg-white border border-gray-300 rounded focus:outline-none focus:border-green-500 importance-input df9-input"
                                                                data-key="{{ $key }}">
                                                            <span class="font-bold text-gray-600">%</span>
                                                        </div>
                                                    </td>
                                                @elseif($type === 'DF10')
                                                    <td class="importance-cell">
                                                        <div class="flex items-center justify-center gap-1">
                                                            <input type="number" name="inputs[{{ $key }}][importance]"
                                                                value="{{ data_get($designFactor->inputs, $key . '.importance', ($key === 'first_mover' ? 75 : ($key === 'follower' ? 15 : 10))) }}"
                                                                min="0" max="100"
                                                                class="w-20 px-2 py-1 text-center font-extrabold bg-white border border-gray-300 rounded focus:outline-none focus:border-green-500 importance-input df10-input"
                                                                data-key="{{ $key }}">
                                                            <span class="font-bold text-gray-600">%</span>
                                                        </div>
                                                    </td>
                                                @else
                                                    <td class="importance-cell">
                                                        <input type="number" name="inputs[{{ $key }}][importance]"
                                                            value="{{ data_get($designFactor->inputs, $key . '.importance', 3) }}"
                                                            min="1" max="5"
                                                            class="w-16 px-2 py-1 text-center font-extrabold bg-white border border-gray-300 rounded focus:outline-none focus:border-green-500 importance-input"
                                                            data-key="{{ $key }}">
                                                    </td>
                                                @endif

                                                <td class="{{ $type === 'DF3' ? 'df3-baseline' : 'baseline-col' }}">
                                                    @php
                                                        $baselineDefault = 3;
                                                        if ($type === 'DF3') {
                                                            $baselineDefault = 9;
                                                        } elseif ($type === 'DF4') {
                                                            $baselineDefault = 2;
                                                        } elseif ($type === 'DF6') {
                                                            $baselineDefault = $key === 'normal' ? 100 : 0;
                                                        } elseif ($type === 'DF8') {
                                                            $baselineDefault = $key === 'insourced' ? 34 : 33;
                                                        } elseif ($type === 'DF9') {
                                                            $baselineDefault = $key === 'agile' ? 15 : ($key === 'devops' ? 10 : 75);
                                                        } elseif ($type === 'DF10') {
                                                            $baselineDefault = $key === 'first_mover' ? 15 : ($key === 'follower' ? 70 : 15);
                                                        }
                                                    @endphp
                                                    {{ data_get($designFactor->inputs, $key . '.baseline', $baselineDefault) }}{{ in_array($type, ['DF6', 'DF8', 'DF9', 'DF10']) ? '%' : '' }}
                                                    <input type="hidden" name="inputs[{{ $key }}][baseline]"
                                                        value="{{ data_get($designFactor->inputs, $key . '.baseline', $baselineDefault) }}"
                                                        class="baseline-input">
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

                            @if($type === 'DF8')
                                <!-- DF8 Total Display and Legend -->
                                <div class="w-full lg:col-span-3 xl:col-span-2">
                                    <div class="border border-gray-400 overflow-hidden shadow-sm">
                                        <div class="bg-white p-3 border-b border-gray-400">
                                            <p class="text-sm font-bold text-gray-800">Total Importance</p>
                                            <p class="text-2xl font-bold" id="df8TotalDisplay">100%</p>
                                            <p class="text-xs text-gray-500 mt-1" id="df8Warning"></p>
                                        </div>
                                        <div class="bg-green-50 p-3">
                                            <p class="text-xs font-medium text-green-700">Total harus = 100%</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($type === 'DF9')
                                <!-- DF9 Total Display and Legend -->
                                <div class="w-full lg:col-span-3 xl:col-span-2">
                                    <div class="border border-gray-400 overflow-hidden shadow-sm">
                                        <div class="bg-white p-3 border-b border-gray-400">
                                            <p class="text-sm font-bold text-gray-800">Total Importance</p>
                                            <p class="text-2xl font-bold" id="df9TotalDisplay">100%</p>
                                            <p class="text-xs text-gray-500 mt-1" id="df9Warning"></p>
                                        </div>
                                        <div class="bg-green-50 p-3">
                                            <p class="text-xs font-medium text-green-700">Total harus = 100%</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($type === 'DF10')
                                <!-- DF10 Total Display and Legend -->
                                <div class="w-full lg:col-span-3 xl:col-span-2">
                                    <div class="border border-gray-400 overflow-hidden shadow-sm">
                                        <div class="bg-white p-3 border-b border-gray-400">
                                            <p class="text-sm font-bold text-gray-800">Total Importance</p>
                                            <p class="text-2xl font-bold" id="df10TotalDisplay">100%</p>
                                            <p class="text-xs text-gray-500 mt-1" id="df10Warning"></p>
                                        </div>
                                        <div class="bg-green-50 p-3">
                                            <p class="text-xs font-medium text-green-700">Total harus = 100%</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Section 2: Calculated Values -->
                <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-2">
                    <div class="p-5 bg-green-50 border border-green-200 rounded-xl shadow-sm">
                        <p class="text-sm font-medium text-green-700">Average Importance</p>
                        <p class="mt-1 text-3xl font-bold text-green-600" id="avgImpDisplay">
                            {{ number_format($avgImp, 2) }}
                        </p>
                    </div>

                    <div class="p-5 bg-purple-50 border border-purple-200 rounded-xl shadow-sm">
                        <p class="text-sm font-medium text-purple-700">Relative Weighted Factor</p>
                        <p class="mt-1 text-3xl font-bold text-purple-600" id="weightDisplay">
                            {{ number_format($weight, 6) }}
                        </p>
                    </div>
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
                                            {{ in_array($type, ['DF8', 'DF9', 'DF10']) ? number_format($item->baseline_score, 2) : $item->baseline_score }}
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
                <div class="grid grid-cols-1 gap-6 mb-8 xl:grid-cols-2">
                    <div class="p-6 bg-white border border-gray-200 shadow-sm rounded-xl">
                        <h3 class="mb-2 text-lg font-bold text-gray-800">{{ $type }} Output</h3>
                        <div class="relative" style="height: 700px;">
                            <canvas id="barChart"></canvas>
                        </div>
                    </div>

                    <div class="p-6 bg-white border border-gray-200 shadow-sm rounded-xl">
                        <h3 class="mb-2 text-lg font-bold text-gray-800">{{ $type }} Radar</h3>
                        <div class="relative" style="height: 700px;">
                            <canvas id="radarChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="flex justify-center p-6 bg-slate-50 border border-gray-200 rounded-xl shadow-inner">
                    <button type="submit"
                        class="flex items-center px-10 py-4 text-base font-bold text-white bg-green-600 rounded-xl hover:bg-green-700 transform hover:scale-105 transition-all shadow-lg">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                            </path>
                        </svg>
                        Simpan Analisis {{ $type }}
                    </button>
                </div>
            </form>
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
                const itemScoreHiddens = document.querySelectorAll('.item-score-hidden');
                const itemScoreDisplays = document.querySelectorAll('.item-score-display');
                document.querySelectorAll('.item-score-hidden').forEach(input => itemScores.push(parseFloat(input.value) || 0));
                document.querySelectorAll('.item-baseline-hidden').forEach(input => itemBaselines.push(parseFloat(input.value) || 0));

                // DF6 mapping values for dynamic score calculation
                const df6HighValues = [];
                const df6NormalValues = [];
                const df6LowValues = [];
                if (factorType === 'DF6') {
                    document.querySelectorAll('.item-high-value').forEach(input => df6HighValues.push(parseFloat(input.value) || 1));
                    document.querySelectorAll('.item-normal-value').forEach(input => df6NormalValues.push(parseFloat(input.value) || 1));
                    document.querySelectorAll('.item-low-value').forEach(input => df6LowValues.push(parseFloat(input.value) || 1));
                }

                // DF7 mapping values for dynamic score calculation (MMULT formula)
                const df7SupportValues = [];
                const df7FactoryValues = [];
                const df7TurnaroundValues = [];
                const df7StrategicValues = [];
                if (factorType === 'DF7') {
                    document.querySelectorAll('.item-support-value').forEach(input => df7SupportValues.push(parseFloat(input.value) || 1));
                    document.querySelectorAll('.item-factory-value').forEach(input => df7FactoryValues.push(parseFloat(input.value) || 1));
                    document.querySelectorAll('.item-turnaround-value').forEach(input => df7TurnaroundValues.push(parseFloat(input.value) || 1));
                    document.querySelectorAll('.item-strategic-value').forEach(input => df7StrategicValues.push(parseFloat(input.value) || 1));
                }

                // DF8 mapping values for dynamic score calculation (MMULT formula)
                const df8OutsourcingValues = [];
                const df8CloudValues = [];
                const df8InsourcedValues = [];
                if (factorType === 'DF8') {
                    document.querySelectorAll('.item-outsourcing-value').forEach(input => df8OutsourcingValues.push(parseFloat(input.value) || 1));
                    document.querySelectorAll('.item-cloud-value').forEach(input => df8CloudValues.push(parseFloat(input.value) || 1));
                    document.querySelectorAll('.item-insourced-value').forEach(input => df8InsourcedValues.push(parseFloat(input.value) || 1));
                }

                // DF9 mapping values for dynamic score calculation (MMULT formula)
                const df9AgileValues = [];
                const df9DevOpsValues = [];
                const df9TraditionalValues = [];
                if (factorType === 'DF9') {
                    document.querySelectorAll('.item-agile-value').forEach(input => df9AgileValues.push(parseFloat(input.value) || 1));
                    document.querySelectorAll('.item-devops-value').forEach(input => df9DevOpsValues.push(parseFloat(input.value) || 1));
                    document.querySelectorAll('.item-traditional-value').forEach(input => df9TraditionalValues.push(parseFloat(input.value) || 1));
                }

                // DF10 mapping values for dynamic score calculation (MMULT formula)
                const df10FirstMoverValues = [];
                const df10FollowerValues = [];
                const df10SlowAdopterValues = [];
                if (factorType === 'DF10') {
                    document.querySelectorAll('.item-first-mover-value').forEach(input => df10FirstMoverValues.push(parseFloat(input.value) || 1));
                    document.querySelectorAll('.item-follower-value').forEach(input => df10FollowerValues.push(parseFloat(input.value) || 1));
                    document.querySelectorAll('.item-slow-adopter-value').forEach(input => df10SlowAdopterValues.push(parseFloat(input.value) || 1));
                }

                let chartLabels = @json($designFactor->items->pluck('code'));
                let chartData = [];
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
                        const df6Inputs = document.querySelectorAll('.df6-input');
                        let high = 0, normal = 0, low = 0;
                        df6Inputs.forEach(input => {
                            const key = input.dataset.key;
                            const val = parseFloat(input.value) || 0;
                            if (key === 'high') high = val;
                            else if (key === 'normal') normal = val;
                            else if (key === 'low') low = val;
                        });

                        const total = high + normal + low;
                        const df6TotalDisplay = document.getElementById('df6TotalDisplay');
                        const df6Warning = document.getElementById('df6Warning');

                        if (df6TotalDisplay) {
                            df6TotalDisplay.textContent = total + '%';
                            if (total === 100) {
                                df6TotalDisplay.className = 'text-2xl font-bold text-green-600';
                                df6Warning.textContent = '✓ Valid';
                                df6Warning.className = 'text-xs text-green-600 mt-1';
                            } else {
                                df6TotalDisplay.className = 'text-2xl font-bold text-red-600';
                                df6Warning.textContent = '⚠ Total harus 100%';
                                df6Warning.className = 'text-xs text-red-600 mt-1';
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
                        const df8TotalDisplay = document.getElementById('df8TotalDisplay');
                        const df8Warning = document.getElementById('df8Warning');

                        if (df8TotalDisplay) {
                            df8TotalDisplay.textContent = total + '%';
                            if (total === 100) {
                                df8TotalDisplay.className = 'text-2xl font-bold text-green-600';
                                df8Warning.textContent = '✓ Valid';
                                df8Warning.className = 'text-xs text-green-600 mt-1';
                            } else {
                                df8TotalDisplay.className = 'text-2xl font-bold text-red-600';
                                df8Warning.textContent = '⚠ Total harus 100%';
                                df8Warning.className = 'text-xs text-red-600 mt-1';
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
                        const df9TotalDisplay = document.getElementById('df9TotalDisplay');
                        const df9Warning = document.getElementById('df9Warning');
                        
                        if (df9TotalDisplay) {
                            df9TotalDisplay.textContent = total + '%';
                            if (total === 100) {
                                df9TotalDisplay.className = 'text-2xl font-bold text-green-600';
                                df9Warning.textContent = '✓ Valid';
                                df9Warning.className = 'text-xs text-green-600 mt-1';
                            } else {
                                df9TotalDisplay.className = 'text-2xl font-bold text-red-600';
                                df9Warning.textContent = '⚠ Total harus 100%';
                                df9Warning.className = 'text-xs text-red-600 mt-1';
                            }
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
                        const df10TotalDisplay = document.getElementById('df10TotalDisplay');
                        const df10Warning = document.getElementById('df10Warning');
                        
                        if (df10TotalDisplay) {
                            df10TotalDisplay.textContent = total + '%';
                            if (total === 100) {
                                df10TotalDisplay.className = 'text-2xl font-bold text-green-600';
                                df10Warning.textContent = '✓ Valid';
                                df10Warning.className = 'text-xs text-green-600 mt-1';
                            } else {
                                df10TotalDisplay.className = 'text-2xl font-bold text-red-600';
                                df10Warning.textContent = '⚠ Total harus 100%';
                                df10Warning.className = 'text-xs text-red-600 mt-1';
                            }
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
                    } else {
                        importanceInputs.forEach(input => {
                            totalVal += parseFloat(input.value) || 1;
                            count++;
                        });
                        // DF4 has baseline=2, others have baseline=3
                        const defaultBaseline = (factorType === 'DF4') ? 2 : 3;
                        baselineInputs.forEach(input => totalBase += parseFloat(input.value) || defaultBaseline);
                    }

                    const avgImp = totalVal / count;
                    const avgBase = totalBase / count;

                    let weight = 1.0;
                    if (avgImp > 0 && avgBase > 0) {
                        if (factorType === 'DF1' || factorType === 'DF4' || factorType === 'DF7') {
                            // DF1, DF4, and DF7: Baseline / Importance
                            weight = avgBase / avgImp;
                        } else if (factorType === 'DF2' || factorType === 'DF3') {
                            // DF2, DF3: Importance / Baseline
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

                    avgImpDisplay.textContent = avgImp.toFixed(2);
                    weightDisplay.textContent = weight.toFixed(6);

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

                    updateCharts();
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
                });
                df3Inputs.forEach(input => {
                    input.addEventListener('input', function () {
                        validateMaxValue(this);
                        calculate();
                    });
                });

                initCharts();
                calculate();
            });
        </script>
    @endpush
</x-app-layout>