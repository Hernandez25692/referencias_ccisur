@php
    $canBack = url()->previous() !== url()->current();
@endphp

<a href="{{ route('dashboard') }}"
    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-[#002c5f] text-[#002c5f] hover:bg-[#002c5f] hover:text-white transition focus:outline-none focus:ring-2 focus:ring-[#b79a37]">
    <i class="ph ph-house"></i> Ir al Panel
</a>

@if ($canBack)
    <button onclick="history.back()"
        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-100 transition focus:outline-none focus:ring-2 focus:ring-[#b79a37]">
        <i class="ph ph-arrow-left"></i> Volver
    </button>
@endif


