@props(['name', 'label', 'type' => 'text', 'value' => null, 'placeholder' => null, 'required' => false, 'help' => null, 'options' => [], 'accept' => null])

@php
$hasError = $errors->has($name);
$errorClass = $hasError ? 'border-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-orange-500 focus:ring-orange-500';
$inputId = 'input_' . $name;
$placeholder = $placeholder ?: $label;
@endphp

<div class="mb-4">
    <!-- Label -->
    <label for="{{ $inputId }}" class="block text-sm font-medium text-gray-700 mb-2">
        {{ $label }}
        @if($required)
            <span class="text-red-500">*</span>
        @endif
    </label>

    <!-- Input Field -->
    @if($type === 'select')
        <select 
            id="{{ $inputId }}"
            name="{{ $name }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge(['class' => "mt-1 block w-full rounded-md shadow-sm $errorClass sm:text-sm transition-colors duration-150"]) }}
        >
            <option value="">Pilih {{ $label }}</option>
            @foreach($options as $optionValue => $optionLabel)
                <option value="{{ $optionValue }}" {{ old($name, $value) == $optionValue ? 'selected' : '' }}>
                    {{ $optionLabel }}
                </option>
            @endforeach
        </select>

    @elseif($type === 'textarea')
        <textarea 
            id="{{ $inputId }}"
            name="{{ $name }}"
            placeholder="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
            rows="4"
            {{ $attributes->merge(['class' => "mt-1 block w-full rounded-md shadow-sm $errorClass sm:text-sm transition-colors duration-150"]) }}
        >{{ old($name, $value) }}</textarea>

    @elseif($type === 'file')
        <input 
            type="file"
            id="{{ $inputId }}"
            name="{{ $name }}"
            {{ $required ? 'required' : '' }}
            {{ $accept ? "accept=$accept" : '' }}
            {{ $attributes->merge(['class' => "mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 transition-colors duration-150"]) }}
        />

    @elseif($type === 'checkbox')
        <div class="flex items-center">
            <input 
                type="checkbox"
                id="{{ $inputId }}"
                name="{{ $name }}"
                value="1"
                {{ old($name, $value) ? 'checked' : '' }}
                {{ $required ? 'required' : '' }}
                {{ $attributes->merge(['class' => "h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded transition-colors duration-150"]) }}
            />
            <label for="{{ $inputId }}" class="ml-2 block text-sm text-gray-900">
                {{ $label }}
                @if($required)
                    <span class="text-red-500">*</span>
                @endif
            </label>
        </div>

    @elseif($type === 'radio')
        <div class="space-y-2">
            @foreach($options as $optionValue => $optionLabel)
                <div class="flex items-center">
                    <input 
                        type="radio"
                        id="{{ $inputId }}_{{ $optionValue }}"
                        name="{{ $name }}"
                        value="{{ $optionValue }}"
                        {{ old($name, $value) == $optionValue ? 'checked' : '' }}
                        {{ $required ? 'required' : '' }}
                        {{ $attributes->merge(['class' => "h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 transition-colors duration-150"]) }}
                    />
                    <label for="{{ $inputId }}_{{ $optionValue }}" class="ml-2 block text-sm text-gray-900">
                        {{ $optionLabel }}
                    </label>
                </div>
            @endforeach
        </div>

    @else
        <input 
            type="{{ $type }}"
            id="{{ $inputId }}"
            name="{{ $name }}"
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge(['class' => "mt-1 block w-full rounded-md shadow-sm $errorClass sm:text-sm transition-colors duration-150"]) }}
        />
    @endif

    <!-- Help Text -->
    @if($help)
        <p class="mt-1 text-xs text-gray-500">{{ $help }}</p>
    @endif

    <!-- Error Message -->
    @if($hasError)
        <p class="mt-1 text-sm text-red-600">{{ $errors->first($name) }}</p>
    @endif
</div>