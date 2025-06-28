<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    Dashboard
        </h2>
                <p class="text-gray-600 text-sm mt-1">
                    Selamat datang kembali di <span class="mykost-orange font-semibold">MY</span><span class="mykost-blue font-semibold">KOST</span>
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Card -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-2xl shadow-lg p-8 mb-8 text-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold">
                                Halo, {{ Auth::user()->nama }}! 👋
                            </h3>
                            <p class="text-blue-100 mt-1">
                                Role: <span class="font-semibold">{{ Auth::user()->role }}</span>
                            </p>
                        </div>
                    </div>
                    
                    @if(Auth::user()->role === 'Admin')
                        <div class="hidden md:block">
                            <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-lg p-4 border border-white border-opacity-20">
                                <p class="text-sm opacity-90 mb-2">Admin Access</p>
                                <a href="#" class="inline-flex items-center px-4 py-2 bg-white text-blue-600 font-semibold rounded-lg hover:bg-gray-100 transition duration-200">
                                    <span>Panel Admin</span>
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Role Specific Content -->
                    @if(Auth::user()->role === 'Admin')
                        <!-- Admin Dashboard Content -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <div class="flex items-center mb-6">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900">Administrator Panel</h4>
                                    <p class="text-gray-600 text-sm">Kelola sistem MYKOST dengan mudah</p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                <a href="#" class="group p-4 border border-gray-200 rounded-xl hover:border-blue-300 hover:bg-blue-50 transition duration-200">
                                    <div class="text-center">
                                        <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-orange-200 transition duration-200">
                                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h5M9 7h6m-6 4h6m-6 4h6"></path>
                                            </svg>
                                        </div>
                                        <p class="text-sm font-medium text-gray-900">Kelola Kamar</p>
                                    </div>
                                </a>
                                
                                <a href="#" class="group p-4 border border-gray-200 rounded-xl hover:border-blue-300 hover:bg-blue-50 transition duration-200">
                                    <div class="text-center">
                                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-green-200 transition duration-200">
                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                        </div>
                                        <p class="text-sm font-medium text-gray-900">Penghuni</p>
                                    </div>
                                </a>
                                
                                <a href="#" class="group p-4 border border-gray-200 rounded-xl hover:border-blue-300 hover:bg-blue-50 transition duration-200">
                                    <div class="text-center">
                                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-purple-200 transition duration-200">
                                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                        <p class="text-sm font-medium text-gray-900">Laporan</p>
                                    </div>
                                </a>
                                
                                <a href="#" class="group p-4 border border-gray-200 rounded-xl hover:border-blue-300 hover:bg-blue-50 transition duration-200">
                                    <div class="text-center">
                                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-red-200 transition duration-200">
                                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L5.482 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                            </svg>
                                        </div>
                                        <p class="text-sm font-medium text-gray-900">Pengaduan</p>
                                    </div>
                                </a>
                                
                                <a href="#" class="group p-4 border border-gray-200 rounded-xl hover:border-blue-300 hover:bg-blue-50 transition duration-200">
                                    <div class="text-center">
                                        <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-yellow-200 transition duration-200">
                                            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                            </svg>
                                        </div>
                                        <p class="text-sm font-medium text-gray-900">Pembayaran</p>
                                    </div>
                                </a>
                                
                                <a href="#" class="group p-4 border border-gray-200 rounded-xl hover:border-blue-300 hover:bg-blue-50 transition duration-200">
                                    <div class="text-center">
                                        <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-indigo-200 transition duration-200">
                                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        </div>
                                        <p class="text-sm font-medium text-gray-900">Pengaturan</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @else
                        <!-- User Dashboard Content -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <div class="flex items-center mb-6">
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2H3v2zm9 0v2m0 4v2m-4-3h8"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900">Fitur Pengguna</h4>
                                    <p class="text-gray-600 text-sm">Cari dan pesan kamar kost impian Anda</p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <a href="#" class="group p-6 border-2 border-dashed border-gray-300 rounded-xl hover:border-green-400 hover:bg-green-50 transition duration-200 text-center">
                                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-green-200 transition duration-200">
                                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                    <h5 class="font-semibold text-gray-900 mb-2">Cari Kamar</h5>
                                    <p class="text-sm text-gray-600">Temukan kamar kost yang sesuai dengan kebutuhan dan budget Anda</p>
                                </a>
                                
                                <a href="#" class="group p-6 border-2 border-dashed border-gray-300 rounded-xl hover:border-blue-400 hover:bg-blue-50 transition duration-200 text-center">
                                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-200 transition duration-200">
                                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <h5 class="font-semibold text-gray-900 mb-2">Booking Kamar</h5>
                                    <p class="text-sm text-gray-600">Lakukan pemesanan kamar dengan mudah dan aman</p>
                                </a>
                            </div>
                        </div>

                        @if(Auth::user()->hasActivePenghuni())
                            <!-- Active Penghuni Features -->
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                                <div class="flex items-center mb-6">
                                    <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mr-4">
                                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h5"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-semibold text-gray-900">Panel Penghuni</h4>
                                        <p class="text-gray-600 text-sm">Kelola dan pantau status penghunian Anda</p>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <a href="#" class="group p-4 border border-gray-200 rounded-xl hover:border-indigo-300 hover:bg-indigo-50 transition duration-200 text-center">
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-blue-200 transition duration-200">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                        <p class="text-sm font-medium text-gray-900">History</p>
                                    </a>
                                    
                                    <a href="#" class="group p-4 border border-gray-200 rounded-xl hover:border-indigo-300 hover:bg-indigo-50 transition duration-200 text-center">
                                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-green-200 transition duration-200">
                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <p class="text-sm font-medium text-gray-900">Perpanjang</p>
                                    </a>
                                    
                                    <a href="#" class="group p-4 border border-gray-200 rounded-xl hover:border-indigo-300 hover:bg-indigo-50 transition duration-200 text-center">
                                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-red-200 transition duration-200">
                                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L5.482 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                            </svg>
                                        </div>
                                        <p class="text-sm font-medium text-gray-900">Pengaduan</p>
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Account Status -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h4 class="font-semibold text-gray-900 mb-4">Status Akun</h4>
                        
                        @if(!Auth::user()->hasVerifiedEmail())
                            <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg mb-4">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L5.482 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                    <div>
                                        <p class="text-yellow-800 font-medium text-sm">Email Belum Terverifikasi</p>
                                        <p class="text-yellow-700 text-xs mt-1">Verifikasi email untuk akses penuh</p>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <a href="{{ route('verification.notice') }}" class="inline-flex items-center px-3 py-2 border border-yellow-300 rounded-md text-xs font-medium text-yellow-700 bg-yellow-100 hover:bg-yellow-200 transition duration-200">
                                        Verifikasi Sekarang
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center p-4 bg-green-50 border border-green-200 rounded-lg mb-4">
                                <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <p class="text-green-800 font-medium text-sm">Email Terverifikasi</p>
                                    <p class="text-green-700 text-xs mt-1">Akun Anda sudah aktif penuh</p>
                                </div>
                            </div>
                        @endif

                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Role:</span>
                                <span class="font-medium text-gray-900">{{ Auth::user()->role }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Email:</span>
                                <span class="font-medium text-gray-900 truncate ml-2">{{ Auth::user()->email }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">No. HP:</span>
                                <span class="font-medium text-gray-900">{{ Auth::user()->no_hp }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h4 class="font-semibold text-gray-900 mb-4">Aksi Cepat</h4>
                        <div class="space-y-3">
                            <a href="{{ route('profile.edit') }}" class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200">
                                <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="text-sm font-medium">Edit Profil</span>
                            </a>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200">
                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    <span class="text-sm font-medium">Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
