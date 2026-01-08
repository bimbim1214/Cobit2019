<x-app-layout>
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeInUp { animation: fadeInUp 0.5s ease-out forwards; }
        .animation-delay-100 { animation-delay: 0.1s; opacity: 0; }
        .animation-delay-200 { animation-delay: 0.2s; opacity: 0; }
        
        .glass-effect {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }
    </style>

    <div class="min-h-screen py-8 bg-slate-950 bg-gradient-to-br from-slate-950 via-gray-900 to-slate-900">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            
            {{-- Header Section --}}
            <div class="mb-8 animate-fadeInUp">
                <div class="relative overflow-hidden shadow-2xl glass-effect rounded-3xl">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-600/10 via-purple-600/5 to-pink-600/10"></div>
                    <div class="relative p-8">
                        <div class="flex flex-col items-start justify-between space-y-6 lg:flex-row lg:items-center lg:space-y-0">
                            <div class="flex-1">
                                <h1 class="text-4xl font-bold text-transparent bg-gradient-to-r from-blue-400 via-purple-400 to-pink-400 bg-clip-text">
                                    My Assessments 📋
                                </h1>
                                <p class="mt-3 text-lg text-gray-400">
                                    Daftar tugas audit yang ditugaskan kepada Anda
                                </p>
                                <div class="flex items-center mt-4 space-x-4">
                                    <div class="flex items-center px-3 py-1 text-sm font-medium text-blue-400 bg-blue-900/50 rounded-full">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $assessments->count() }} Assessment
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        Terakhir diperbarui: {{ now()->format('d M Y, H:i') }}
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col space-y-3 sm:flex-row sm:space-y-0 sm:space-x-4">
                                <a href="{{ route('audit.index') }}"
                                    class="inline-flex items-center px-6 py-3 text-sm font-medium text-white transition-all duration-200 shadow-lg bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 rounded-xl hover:shadow-xl hover:scale-105">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Mulai Audit
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Alert Messages --}}
            @if (session('success'))
                <div class="p-4 mb-6 text-green-400 bg-green-900/30 border border-green-500/50 rounded-xl animate-fadeInUp">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="p-4 mb-6 text-red-400 bg-red-900/30 border border-red-500/50 rounded-xl animate-fadeInUp">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            {{-- Assessment Cards --}}
            @if($assessments->isEmpty())
                <div class="p-16 text-center glass-effect rounded-2xl animate-fadeInUp animation-delay-100" style="opacity:0;">
                    <div class="inline-flex items-center justify-center w-24 h-24 mb-6 bg-slate-800 rounded-2xl text-slate-500">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white">Belum Ada Assessment</h3>
                    <p class="mt-2 text-gray-400">Anda belum memiliki assessment yang ditugaskan.</p>
                    <p class="mt-1 text-gray-500 text-sm">Hubungi admin jika Anda memerlukan akses audit.</p>
                </div>
            @else
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 animate-fadeInUp animation-delay-100" style="opacity:0;">
                    @foreach($assessments as $assessment)
                        @php
                            $statusConfig = [
                                'pending_submission' => ['bg' => 'bg-slate-700', 'text' => 'text-slate-300', 'label' => 'Draft'],
                                'pending_approval' => ['bg' => 'bg-yellow-900/50', 'text' => 'text-yellow-400', 'label' => 'Menunggu Persetujuan'],
                                'approved' => ['bg' => 'bg-blue-900/50', 'text' => 'text-blue-400', 'label' => 'Disetujui'],
                                'in_progress' => ['bg' => 'bg-indigo-900/50', 'text' => 'text-indigo-400', 'label' => 'Sedang Dikerjakan'],
                                'completed' => ['bg' => 'bg-orange-900/50', 'text' => 'text-orange-400', 'label' => 'Selesai'],
                                'verified' => ['bg' => 'bg-green-900/50', 'text' => 'text-green-400', 'label' => 'Terverifikasi'],
                                'rejected' => ['bg' => 'bg-red-900/50', 'text' => 'text-red-400', 'label' => 'Ditolak'],
                            ];
                            $config = $statusConfig[$assessment->status] ?? $statusConfig['pending_submission'];
                        @endphp
                        
                        <div class="flex flex-col overflow-hidden glass-effect rounded-2xl card-hover group">
                            {{-- Status Badge --}}
                            <div class="px-6 pt-6 pb-4">
                                <div class="flex items-start justify-between mb-4">
                                    <span class="inline-flex px-3 py-1 rounded-lg text-xs font-semibold {{ $config['bg'] }} {{ $config['text'] }}">
                                        {{ $config['label'] }}
                                    </span>
                                    <span class="text-xs text-gray-500">
                                        {{ $assessment->created_at->format('d M Y') }}
                                    </span>
                                </div>
                                
                                {{-- Assessment Name --}}
                                <h3 class="text-lg font-bold text-white mb-2 group-hover:text-blue-400 transition-colors">
                                    {{ $assessment->name ?? 'Assessment #' . $assessment->id }}
                                </h3>
                                
                                {{-- COBIT Items --}}
                                <div class="flex flex-wrap gap-1.5 mb-4">
                                    @foreach($assessment->cobitItems->take(3) as $item)
                                        <span class="px-2 py-0.5 text-xs font-medium text-blue-400 bg-blue-900/30 rounded-md">
                                            {{ $item->nama_item }}
                                        </span>
                                    @endforeach
                                    @if($assessment->cobitItems->count() > 3)
                                        <span class="text-xs text-gray-500">+{{ $assessment->cobitItems->count() - 3 }} lainnya</span>
                                    @endif
                                </div>
                                
                                {{-- Progress --}}
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-medium text-gray-400">Progress</span>
                                        <span class="text-sm font-bold text-blue-400">{{ $assessment->progress ?? 0 }}%</span>
                                    </div>
                                    <div class="w-full h-2 bg-slate-700 rounded-full overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full transition-all duration-500" style="width: {{ $assessment->progress ?? 0 }}%"></div>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Actions --}}
                            <div class="mt-auto p-4 bg-slate-900/50 flex gap-2 border-t border-slate-700/50">
                                <a href="{{ route('user.assessments.show', $assessment) }}" 
                                    class="flex-1 py-2.5 text-center text-sm font-semibold text-white bg-slate-700 hover:bg-slate-600 rounded-xl transition-all">
                                    Lihat Detail
                                </a>
                                
                                @if($assessment->status === 'approved')
                                    <form action="{{ route('user.assessments.start', $assessment) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit" class="w-full py-2.5 text-center text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 rounded-xl transition-all">
                                            Mulai
                                        </button>
                                    </form>
                                @elseif($assessment->status === 'in_progress')
                                    <a href="{{ route('audit.index') }}" class="flex-1 py-2.5 text-center text-sm font-semibold text-white bg-gradient-to-r from-green-600 to-teal-600 hover:from-green-700 hover:to-teal-700 rounded-xl transition-all">
                                        Lanjutkan
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
