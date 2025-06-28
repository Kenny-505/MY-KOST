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
];

$iconClasses = [
    'chart-bar' => 'M3 3v18h18v-2H5V3H3zm14 6v9h2V9h-2zm-4-3v12h2V6h-2zm-4 6v6h2v-6H9z',
    'users' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
    'home' => 'M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z',
    'clipboard-list' => 'M9 2a1 1 0 000 2h2a1 1 0 100-2H9z M4 5a2 2 0 012-2v1a1 1 0 001 1h6a1 1 0 001-1V3a2 2 0 012 2v6h-3a5 5 0 00-5 5v-1H4V5z M11 17a1 1 0 102 0v-1a3 3 0 013-3h1a1 1 0 100-2h-1a5 5 0 00-5 5v1z',
    'currency-dollar' => 'M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.51-1.31c-.562-.649-1.413-1.076-2.353-1.253V5z',
    'exclamation-triangle' => 'M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z',
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