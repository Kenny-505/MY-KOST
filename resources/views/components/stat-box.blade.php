@props(['title', 'value', 'icon' => 'chart-bar', 'color' => 'blue', 'subtitle' => null])

@php
$colorClasses = [
    'blue' => 'from-blue-500 to-blue-600 text-white',
    'green' => 'from-green-500 to-green-600 text-white',
    'yellow' => 'from-yellow-500 to-yellow-600 text-white',
    'red' => 'from-red-500 to-red-600 text-white',
    'purple' => 'from-purple-500 to-purple-600 text-white',
    'orange' => 'from-orange-500 to-orange-600 text-white',
    'indigo' => 'from-indigo-500 to-indigo-600 text-white',
    'pink' => 'from-pink-500 to-pink-600 text-white',
    'gray' => 'from-gray-500 to-gray-600 text-white',
];

// Comprehensive and consistent icon library
$iconClasses = [
    // Analytics & Charts
    'chart-bar' => 'M3 3v18h18v-2H5V3H3zm14 6v9h2V9h-2zm-4-3v12h2V6h-2zm-4 6v6h2v-6H9z',
    'chart-trending-up' => 'M2.64 6.64a1 1 0 011.41 0L6 8.59l2.64-2.64a1 1 0 011.41 0L13 8.9l2.64-2.64a1 1 0 111.41 1.41l-3.34 3.35a1 1 0 01-1.41 0L10 8.59 7.36 11.23a1 1 0 01-1.41 0L2.64 8.05a1 1 0 010-1.41z M2 4a1 1 0 011-1h14a1 1 0 110 2H3a1 1 0 01-1-1z M2 16a1 1 0 011-1h14a1 1 0 110 2H3a1 1 0 01-1-1z',
    
    // People & Users  
    'users' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0',
    'user-check' => 'M5 6a3 3 0 116 0 3 3 0 01-6 0zM1.615 16.428a1.224 1.224 0 01-.569-1.175 6.002 6.002 0 0111.908 0c.058.467-.172.92-.57 1.174A9.953 9.953 0 018 18a9.953 9.953 0 01-6.385-1.572zM16.25 5.75a.75.75 0 00-1.5 0v2.5H12a.75.75 0 000 1.5h2.75v2.5a.75.75 0 001.5 0v-2.5H19a.75.75 0 000-1.5h-2.75v-2.5z',
    'user-x' => 'M5 6a3 3 0 116 0 3 3 0 01-6 0zM1.615 16.428a1.224 1.224 0 01-.569-1.175 6.002 6.002 0 0111.908 0c.058.467-.172.92-.57 1.174A9.953 9.953 0 018 18a9.953 9.953 0 01-6.385-1.572zM13.28 7.22a.75.75 0 00-1.06 1.06L14.94 10l-2.72 2.72a.75.75 0 101.06 1.06L16 11.06l2.72 2.72a.75.75 0 101.06-1.06L17.06 10l2.72-2.72a.75.75 0 00-1.06-1.06L16 8.94l-2.72-2.72z',
    'user-plus' => 'M5 6a3 3 0 116 0 3 3 0 01-6 0zM1.615 16.428a1.224 1.224 0 01-.569-1.175 6.002 6.002 0 0111.908 0c.058.467-.172.92-.57 1.174A9.953 9.953 0 018 18a9.953 9.953 0 01-6.385-1.572zM16.25 5.75a.75.75 0 00-1.5 0v2.5H12a.75.75 0 000 1.5h2.75v2.5a.75.75 0 001.5 0v-2.5H19a.75.75 0 000-1.5h-2.75v-2.5z',
    
    // Property & Housing
    'home' => 'M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z',
    'building' => 'M4 3a2 2 0 100 4h12a2 2 0 100-4H4z M3 8a2 2 0 012-2v10a2 2 0 01-2 2 2 2 0 01-2-2V8a2 2 0 012-2z M16 6a2 2 0 00-2 2v10a2 2 0 002 2 2 2 0 002-2V8a2 2 0 00-2-2z',
    
    // Calendar & Time
    'calendar' => 'M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zM4 9h12v7H4V9z',
    'calendar-check' => 'M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zM4 9h12v7H4V9z M13.293 11.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-2-2a1 1 0 111.414-1.414L10 14.586l3.293-3.293z',
    'calendar-days' => 'M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zM4 9h12v7H4V9z M7 11a1 1 0 100 2 1 1 0 000-2z M10 11a1 1 0 100 2 1 1 0 000-2z M13 11a1 1 0 100 2 1 1 0 000-2z',
    'clock' => 'M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V5z',
    
    // Financial & Payments
    'currency-dollar' => 'M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.51-1.31c-.562-.649-1.413-1.076-2.353-1.253V5z',
    'cash' => 'M1 4a1 1 0 011-1h16a1 1 0 011 1v8a1 1 0 01-1 1H2a1 1 0 01-1-1V4zm3 3a1 1 0 100 2h.01a1 1 0 100-2H4zm2 0a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm10 0a1 1 0 100 2h.01a1 1 0 100-2H16z',
    'receipt-tax' => 'M4 2a2 2 0 00-2 2v12a2 2 0 002 2h.5a.5.5 0 01.5.5v2a.5.5 0 00.854.354L7.707 17H16a2 2 0 002-2V4a2 2 0 00-2-2H4zm4 6a1 1 0 100-2 1 1 0 000 2zm3 0a1 1 0 100-2 1 1 0 000 2zm1 3a1 1 0 11-2 0 1 1 0 012 0zm-3 0a1 1 0 11-2 0 1 1 0 012 0z',
    
    // Status & Alerts
    'check-circle' => 'M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z',
    'x-circle' => 'M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z',
    'exclamation-triangle' => 'M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z',
    'exclamation-circle' => 'M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z',
    'badge-check' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z',
    'chart-pie' => 'M11 2v7.5a.5.5 0 00.5.5H19a8 8 0 11-8-8z M15.5 2.134a1 1 0 011 .866v2a1 1 0 01-1 1h-2a1 1 0 01-.866-1.5l2-3.464a1 1 0 01.866-.5z',
    
    // Documents & Lists
    'clipboard-list' => 'M9 2a1 1 0 000 2h2a1 1 0 100-2H9z M4 5a2 2 0 012-2v1a1 1 0 001 1h6a1 1 0 001-1V3a2 2 0 012 2v6h-3a5 5 0 00-5 5v-1H4V5z M11 17a1 1 0 102 0v-1a3 3 0 713-3h1a1 1 0 100-2h-1a5 5 0 00-5 5v1z',
    'document-text' => 'M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z',
];

$gradientClass = $colorClasses[$color] ?? $colorClasses['blue'];
$iconPath = $iconClasses[$icon] ?? $iconClasses['chart-bar'];
@endphp

<div class="bg-gradient-to-r {{ $gradientClass }} rounded-xl shadow-lg p-6 transform transition-all duration-200 hover:scale-105 hover:shadow-xl">
    <div class="flex items-center justify-between">
        <div class="flex-1">
            <h3 class="text-sm font-medium opacity-90 mb-1">{{ $title }}</h3>
            <p class="text-3xl font-bold mb-1">{{ $value }}</p>
            @if($subtitle)
                <p class="text-xs opacity-75">{{ $subtitle }}</p>
            @endif
        </div>
        <div class="ml-4">
            <div class="bg-white bg-opacity-20 rounded-lg p-3">
                <svg class="w-8 h-8 fill-current" viewBox="0 0 20 20">
                    <path d="{{ $iconPath }}"/>
                </svg>
            </div>
        </div>
    </div>
</div>