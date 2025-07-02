<x-admin-layout>
    <x-slot name="pageTitle">Dashboard</x-slot>
    <x-slot name="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800">Dashboard</a></li>
    </x-slot>

    <!-- Dashboard Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        @foreach($stats as $key => $stat)
            <x-stat-box 
                :title="$stat['label']"
                :value="$stat['value']"
                :icon="$stat['icon']"
                :color="$stat['color']"
                :subtitle="$stat['subtitle'] ?? null"
            />
        @endforeach
    </div>

    <!-- Quick Actions & Recent Activities -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Recent Activities -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h2 class="text-lg font-semibold text-gray-900">Aktivitas Terkini</h2>
            </div>
            
            <div class="divide-y divide-gray-200">
                @forelse($recentActivities as $activity)
                    <div class="p-4 hover:bg-gray-50 transition-colors duration-150">
                        <div class="flex items-center">
                            @if($activity['type'] === 'payment')
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-4">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                </div>
                            @else
                                <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center mr-4">
                                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L5.482 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                </div>
                            @endif
                            <div class="flex-1">
                                <p class="text-sm text-gray-900">{{ $activity['message'] }}</p>
                                <div class="flex items-center mt-1">
                                    <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($activity['time'])->diffForHumans() }}</span>
                                    <span class="mx-2 text-gray-300">•</span>
                                    <span @class([
                                        'text-xs font-medium px-2 py-0.5 rounded-full',
                                        'bg-green-100 text-green-800' => $activity['status'] === 'Lunas' || $activity['status'] === 'Selesai',
                                        'bg-yellow-100 text-yellow-800' => $activity['status'] === 'Menunggu' || $activity['status'] === 'Diproses',
                                        'bg-red-100 text-red-800' => $activity['status'] === 'Gagal' || $activity['status'] === 'Dibatalkan',
                                    ])>
                                        {{ $activity['status'] }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-gray-500">
                        Tidak ada aktivitas terkini
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Quick Management -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h2 class="text-lg font-semibold text-gray-900">Manajemen Cepat</h2>
            </div>
            
            <div class="px-8 py-10">
                <div class="grid grid-cols-2 gap-x-8 gap-y-8">
                    <a href="{{ route('admin.kamar.index') }}" 
                       class="group py-8 px-7 border border-gray-200 rounded-xl hover:border-blue-300 hover:bg-blue-50 transition-all duration-200 min-h-[120px] flex items-center">
                        <div class="flex items-center w-full">
                            <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center mr-5 group-hover:bg-blue-200 transition-colors duration-200 flex-shrink-0">
                                <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h5"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-bold text-gray-900 text-base">Kelola Kamar</p>
                                <p class="text-sm text-gray-500 mt-2">Atur kamar dan tipe</p>
                            </div>
                        </div>
                    </a>
                    
                    <a href="{{ route('admin.penghuni.index') }}" 
                       class="group py-8 px-7 border border-gray-200 rounded-xl hover:border-green-300 hover:bg-green-50 transition-all duration-200 min-h-[120px] flex items-center">
                        <div class="flex items-center w-full">
                            <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center mr-5 group-hover:bg-green-200 transition-colors duration-200 flex-shrink-0">
                                <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-bold text-gray-900 text-base">Kelola Penghuni</p>
                                <p class="text-sm text-gray-500 mt-2">Atur data penghuni</p>
                            </div>
                        </div>
                    </a>
                    
                    <a href="{{ route('admin.pengaduan.index') }}" 
                       class="group py-8 px-7 border border-gray-200 rounded-xl hover:border-orange-300 hover:bg-orange-50 transition-all duration-200 min-h-[120px] flex items-center">
                        <div class="flex items-center w-full">
                            <div class="w-14 h-14 bg-orange-100 rounded-xl flex items-center justify-center mr-5 group-hover:bg-orange-200 transition-colors duration-200 flex-shrink-0">
                                <svg class="w-7 h-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L5.482 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-bold text-gray-900 text-base">Kelola Pengaduan</p>
                                <p class="text-sm text-gray-500 mt-2">Tangani pengaduan</p>
                            </div>
                        </div>
                    </a>
                    
                    <a href="{{ route('admin.invoice.index') }}" 
                       class="group py-8 px-7 border border-gray-200 rounded-xl hover:border-purple-300 hover:bg-purple-50 transition-all duration-200 min-h-[120px] flex items-center">
                        <div class="flex items-center w-full">
                            <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center mr-5 group-hover:bg-purple-200 transition-colors duration-200 flex-shrink-0">
                                <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-bold text-gray-900 text-base">Invoice</p>
                                <p class="text-sm text-gray-500 mt-2">Kelola pembayaran</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout> 