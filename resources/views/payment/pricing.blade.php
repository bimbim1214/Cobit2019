<x-app-layout>
    <div class="py-12 min-h-screen bg-slate-950 dark:bg-gray-900 bg-gradient-to-br from-slate-950 via-gray-900 to-slate-900">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mb-10 text-center">
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl">Pilih Paket Layanan</h2>
                <p class="mt-4 text-xl text-slate-400">Silakan pilih paket berlangganan untuk mengakses sistem audit TI.</p>
            </div>

            @if(session('error'))
                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid gap-8 lg:grid-cols-3">
                @foreach($packages as $package)
                    <div class="flex flex-col overflow-hidden bg-slate-900/50 border border-slate-700 rounded-lg shadow-lg backdrop-blur-sm">
                        <div class="p-6 bg-slate-800/50 border-b border-slate-700">
                            <h3 class="text-lg font-medium tracking-wide text-center text-white uppercase">{{ $package->name }}</h3>
                            <div class="flex items-baseline justify-center mt-4 text-center">
                                <span class="text-3xl font-extrabold text-white tracking-tight">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
                            </div>
                            <p class="mt-2 text-center text-slate-400 text-sm">Masa aktif {{ $package->duration_days }} hari</p>
                        </div>
                        <div class="flex flex-col flex-1 p-6 bg-slate-900/40">
                            <div class="flex-1">
                                <p class="text-slate-300 text-center">
                                    {!! nl2br(e($package->description)) !!}
                                </p>
                            </div>
                            <div class="mt-8">
                                <a href="{{ route('payment.checkout', $package->id) }}" class="flex items-center justify-center w-full px-4 py-2 font-semibold text-white transition-colors duration-150 bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Pilih Paket
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
