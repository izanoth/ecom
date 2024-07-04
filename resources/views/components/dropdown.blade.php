@props(['align', 'width', 'contentClasses'])


@php
    $align = $align ?? 'right';
    $width = $width ?? 'w-48';
    $contentClasses = $contentClasses ?? 'py-1 bg-sky-100 dark:bg-gray-700';

    switch ($align) {
        case 'left':
            $alignmentClasses =
                'absolute z-50 mt-2 rounded-md shadow-lg ltr:origin-top-left rtl:origin-top-right start-0';
            break;
        case 'top':
            $alignmentClasses = 'origin-top-yop';
            break;
        case 'right':
        default:
            $alignmentClasses =
                'absolute z-50 mt-2 rounded-md shadow-lg ltr:origin-top-right rtl:origin-top-left end-0 ';
            break;
    }
@endphp
<!--
    //Tailwind utils classess
    // absolute sm:start-1/2 sm:-translate-x-1/2 === media (max-width: 639px) { left: 50%; transform: translateX(-50%) }
-->
<div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
    <div @click="open = ! open">
        {{ $trigger }}
    </div>
    <style>
        #dropdown-panel {
            @media (max-width: 639px) {
                left: 50%;
                transform: translateX(-50%);
            }
        }
    </style>

    <div x-show="open" x-transition:enter="transition ease-out duration-200" 
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100" 
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100" 
        x-transition:leave-end="opacity-0 scale-95"
        class="{{ $width }} {{ $alignmentClasses }}" 
        style="display: none"
        id="dropdown-panel" 
        @click="open = false">
        <div class="rounded-md ring-1 ring-black ring-opacity-5 {{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>
