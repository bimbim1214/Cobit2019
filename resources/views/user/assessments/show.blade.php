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
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
    </style>

    <div class="min-h-screen py-8 bg-slate-950 bg-gradient-to-br from-slate-950 via-gray-900 to-slate-900">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            
            {{-- Back Button --}}
            <div class="mb-6 animate-fadeInUp">
                <a href="{{ route('user.assessments.index') }}" class="inline-flex items-center text-sm font-medium text-blue-400 hover:text-blue-300 transition-colors group">
                    <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Daftar
                </a>
            </div>

            {{-- Header Section --}}
            <div class="mb-8 animate-fadeInUp">
                <div class="relative overflow-hidden shadow-2xl glass-effect rounded-3xl">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-600/10 via-purple-600/5 to-pink-600/10"></div>
                    <div class="relative p-8">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                            <div class="flex-1">
                                @php
                                    $statusConfig = [
                                        'pending_submission' => ['bg' => 'bg-slate-700', 'text' => 'text-slate-300', 'label' => 'Draft'],
                                        'pending_approval' => ['bg' => 'bg-yellow-900/50', 'text' => 'text-yellow-400', 'label' => 'Menunggu Persetujuan'],
                                        'approved' => ['bg' => 'bg-blue-900/50', 'text' => 'text-blue-400', 'label' => 'Disetujui - Siap Dikerjakan'],
                                        'in_progress' => ['bg' => 'bg-indigo-900/50', 'text' => 'text-indigo-400', 'label' => 'Sedang Dikerjakan'],
                                        'completed' => ['bg' => 'bg-orange-900/50', 'text' => 'text-orange-400', 'label' => 'Selesai - Menunggu Verifikasi'],
                                        'verified' => ['bg' => 'bg-green-900/50', 'text' => 'text-green-400', 'label' => 'Terverifikasi'],
                                        'rejected' => ['bg' => 'bg-red-900/50', 'text' => 'text-red-400', 'label' => 'Ditolak'],
                                    ];
                                    $config = $statusConfig[$assessment->status] ?? $statusConfig['pending_submission'];
                                @endphp
                                
                                <div class="flex items-center gap-3 mb-4">
                                    <span class="px-4 py-1.5 rounded-lg text-sm font-semibold {{ $config['bg'] }} {{ $config['text'] }}">
                                        {{ $config['label'] }}
                                    </span>
                                    <span class="text-gray-500">•</span>
                                    <span class="text-sm text-gray-400">{{ $assessment->created_at->format('d M Y') }}</span>
                                </div>
                                
                                <h1 class="text-3xl lg:text-4xl font-bold text-transparent bg-gradient-to-r from-blue-400 via-purple-400 to-pink-400 bg-clip-text">
                                    {{ $assessment->name ?? 'Assessment #' . $assessment->id }}
                                </h1>
                                <p class="mt-2 text-lg text-gray-400">
                                    Detail assessment dan proses TI yang harus diaudit
                                </p>
                            </div>
                            
                            {{-- Action Buttons --}}
                            <div class="flex flex-wrap gap-3">
                                @if($assessment->status === 'pending_submission')
                                    <form action="{{ route('user.assessments.submit', $assessment) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-6 py-3 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 rounded-xl shadow-lg shadow-blue-500/25 transition-all hover:scale-105">
                                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                            </svg>
                                            Submit untuk Persetujuan
                                        </button>
                                    </form>
                                @elseif($assessment->status === 'approved')
                                    <form action="{{ route('user.assessments.start', $assessment) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-6 py-3 text-sm font-semibold text-white bg-gradient-to-r from-green-600 to-teal-600 hover:from-green-700 hover:to-teal-700 rounded-xl shadow-lg shadow-green-500/25 transition-all hover:scale-105">
                                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Mulai Mengerjakan
                                        </button>
                                    </form>
                                @elseif($assessment->status === 'in_progress')
                                    <a href="{{ route('audit.index') }}" class="px-6 py-3 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 rounded-xl shadow-lg shadow-blue-500/25 transition-all hover:scale-105">
                                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Lanjutkan Pengisian
                                    </a>
                                @endif
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

            @if($assessment->status === 'rejected' && $assessment->rejection_reason)
                <div class="p-6 mb-6 bg-red-900/30 border border-red-500/50 rounded-2xl animate-fadeInUp">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-red-500/20 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-red-400">Assessment Ditolak</h3>
                            <p class="mt-1 text-red-300">{{ $assessment->rejection_reason }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Left Column: COBIT Items --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="p-6 glass-effect rounded-2xl animate-fadeInUp animation-delay-100" style="opacity:0;">
                        <h2 class="text-lg font-semibold text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Proses TI yang Harus Diaudit
                        </h2>
                        
                        <div class="space-y-4">
                            @forelse($assessment->items as $item)
                                <div class="p-5 bg-slate-800/50 border border-slate-700 rounded-xl card-hover group">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center text-white font-bold shadow-lg group-hover:scale-110 transition-transform">
                                                {{ $item->cobitItem->nama_item ?? 'N/A' }}
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-white">{{ $item->cobitItem->nama_item ?? 'Unknown' }}</h4>
                                                <p class="text-sm text-gray-400">{{ Str::limit($item->cobitItem->deskripsi ?? '', 60) }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-2xl font-bold text-blue-400">{{ $item->progress }}%</p>
                                            <p class="text-xs text-gray-500">Progress</p>
                                        </div>
                                    </div>
                                    <div class="w-full h-2 bg-slate-700 rounded-full overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full transition-all duration-500" style="width: {{ $item->progress }}%"></div>
                                    </div>
                                    
                                    @if($assessment->status === 'in_progress')
                                        <div class="mt-4 pt-4 border-t border-slate-700">
                                            <a href="{{ route('audit.showCategories', $item->cobitItem) }}" class="text-sm font-medium text-blue-400 hover:text-blue-300 transition-colors flex items-center gap-2">
                                                Mulai mengisi kuesioner
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="p-8 text-center text-gray-400">
                                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    <p>Belum ada proses TI yang ditugaskan</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Right Column: Timeline & Info --}}
                <div class="space-y-6">
                    {{-- Progress Summary --}}
                    <div class="p-6 glass-effect rounded-2xl animate-fadeInUp animation-delay-100" style="opacity:0;">
                        <h2 class="text-lg font-semibold text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Ringkasan Progress
                        </h2>
                        
                        <div class="flex items-center justify-center mb-4">
                            <div class="relative w-32 h-32">
                                <svg class="w-32 h-32 transform -rotate-90" viewBox="0 0 100 100">
                                    <circle cx="50" cy="50" r="42" fill="none" stroke="currentColor" stroke-width="6" class="text-slate-700"></circle>
                                    <circle cx="50" cy="50" r="42" fill="none" stroke="currentColor" stroke-width="6" class="text-blue-500" 
                                        stroke-dasharray="264" 
                                        stroke-dashoffset="{{ 264 - (264 * ($assessment->progress ?? 0) / 100) }}"
                                        style="transition: stroke-dashoffset 1s ease-in-out;"></circle>
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="text-center">
                                        <span class="text-3xl font-bold text-white">{{ $assessment->progress ?? 0 }}%</span>
                                        <div class="text-xs text-gray-400">Selesai</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 text-center">
                            <div class="p-3 bg-slate-800/50 rounded-xl">
                                <p class="text-2xl font-bold text-blue-400">{{ $assessment->items->count() }}</p>
                                <p class="text-xs text-gray-400">Proses TI</p>
                            </div>
                            <div class="p-3 bg-slate-800/50 rounded-xl">
                                <p class="text-2xl font-bold text-green-400">{{ $assessment->items->where('progress', 100)->count() }}</p>
                                <p class="text-xs text-gray-400">Selesai</p>
                            </div>
                        </div>
                    </div>

                    {{-- Timeline --}}
                    <div class="p-6 glass-effect rounded-2xl animate-fadeInUp animation-delay-200" style="opacity:0;">
                        <h2 class="text-lg font-semibold text-white mb-6 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Timeline
                        </h2>
                        
                        <div class="relative space-y-6">
                            <div class="absolute left-3 top-2 bottom-2 w-0.5 bg-gradient-to-b from-blue-500 via-slate-600 to-slate-700"></div>
                            
                            {{-- Created --}}
                            <div class="relative pl-10">
                                <div class="absolute left-0 top-1 w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center ring-4 ring-slate-900">
                                    <div class="w-2 h-2 bg-white rounded-full"></div>
                                </div>
                                <p class="text-xs font-semibold text-gray-500 uppercase">Dibuat</p>
                                <p class="font-semibold text-white">Assessment Created</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $assessment->created_at->format('d M Y, H:i') }}</p>
                            </div>

                            @if($assessment->submitted_at)
                                <div class="relative pl-10">
                                    <div class="absolute left-0 top-1 w-6 h-6 bg-yellow-500 rounded-full flex items-center justify-center ring-4 ring-slate-900">
                                        <div class="w-2 h-2 bg-white rounded-full"></div>
                                    </div>
                                    <p class="text-xs font-semibold text-gray-500 uppercase">Disubmit</p>
                                    <p class="font-semibold text-white">Submitted for Approval</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ $assessment->submitted_at->format('d M Y, H:i') }}</p>
                                </div>
                            @endif

                            @if($assessment->approved_at)
                                <div class="relative pl-10">
                                    <div class="absolute left-0 top-1 w-6 h-6 {{ $assessment->status === 'rejected' ? 'bg-red-500' : 'bg-green-500' }} rounded-full flex items-center justify-center ring-4 ring-slate-900">
                                        <div class="w-2 h-2 bg-white rounded-full"></div>
                                    </div>
                                    <p class="text-xs font-semibold text-gray-500 uppercase">{{ $assessment->status === 'rejected' ? 'Ditolak' : 'Disetujui' }}</p>
                                    <p class="font-semibold text-white">{{ $assessment->status === 'rejected' ? 'Request Rejected' : 'Approved by Admin' }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ $assessment->approved_at->format('d M Y, H:i') }}</p>
                                    @if($assessment->approver)
                                        <p class="text-xs text-blue-400 mt-1">oleh {{ $assessment->approver->name }}</p>
                                    @endif
                                </div>
                            @endif

                            @if($assessment->completed_at)
                                <div class="relative pl-10">
                                    <div class="absolute left-0 top-1 w-6 h-6 bg-orange-500 rounded-full flex items-center justify-center ring-4 ring-slate-900">
                                        <div class="w-2 h-2 bg-white rounded-full"></div>
                                    </div>
                                    <p class="text-xs font-semibold text-gray-500 uppercase">Selesai</p>
                                    <p class="font-semibold text-white">Assessment Completed</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ $assessment->completed_at->format('d M Y, H:i') }}</p>
                                </div>
                            @endif

                            @if($assessment->verified_at)
                                <div class="relative pl-10">
                                    <div class="absolute left-0 top-1 w-6 h-6 bg-purple-500 rounded-full flex items-center justify-center ring-4 ring-slate-900">
                                        <div class="w-2 h-2 bg-white rounded-full"></div>
                                    </div>
                                    <p class="text-xs font-semibold text-gray-500 uppercase">Terverifikasi</p>
                                    <p class="font-semibold text-white">Verified by Auditor</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ $assessment->verified_at->format('d M Y, H:i') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
