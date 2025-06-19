@extends('layouts.app')

@section('breadcrumbs')
    <li aria-current="page">
        <div class="flex items-center gap-2">
            <i class="ph ph-house text-[#b79a37]"></i>
            <a href="{{ route('referencias.index') }}" class="text-sm text-[#002c5f] hover:underline">Referencias</a>
            <i class="ph ph-arrow-right text-gray-400"></i>
            <span class="text-sm font-medium text-gray-500">Nueva Referencia</span>
        </div>
    </li>
@endsection

@section('content')
<div class="bg-white rounded-xl shadow-lg overflow-hidden p-6 md:p-8 animate__animated animate__fadeIn max-w-2xl mx-auto mt-6">
    <div class="flex items-center justify-between mb-6 border-b pb-4">
        <div>
            <h2 class="text-2xl font-bold text-[#002c5f] flex items-center gap-3">
                <i class="ph ph-plus-circle text-[#b79a37]"></i>
                Nueva Referencia
                <span class="text-base font-normal text-gray-500 ml-2 hidden md:inline">Formulario de registro</span>
            </h2>
            <p class="text-gray-600 text-sm mt-1">Complete el formulario para crear una nueva referencia</p>
        </div>
        <div class="bg-[#b79a37]/10 text-[#b79a37] px-3 py-1 rounded-full text-xs font-semibold tracking-wide shadow-sm">
            {{ strtoupper(Auth::user()->getRoleNames()->first()) }}
        </div>
    </div>

    <form action="{{ route('referencias.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="referenciaForm" autocomplete="off">
        @csrf

        <!-- Asunto -->
        <div class="space-y-2">
            <label class="block text-sm font-medium text-[#002c5f] flex items-center gap-2">
            <i class="ph ph-text-aa text-[#b79a37]"></i>
            Asunto
            <span class="text-red-500">*</span>
            </label>
            <textarea name="asunto"
            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-[#b79a37]/40 focus:border-[#b79a37] focus:outline-none transition duration-200 resize-y min-h-[48px] max-h-60
            @error('asunto') border-red-500 @enderror"
            placeholder="Ingrese el asunto de la referencia">{{ old('asunto') }}</textarea>
            @error('asunto')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Solicitado por -->
        <div class="space-y-2">
            <label class="block text-sm font-medium text-[#002c5f] flex items-center gap-2">
                <i class="ph ph-user-circle text-[#b79a37]"></i>
                Solicitado por
                <span class="text-red-500">*</span>
            </label>
            <input type="text" name="solicitado_por"
                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-[#b79a37]/40 focus:border-[#b79a37] focus:outline-none transition duration-200
                @error('solicitado_por') border-red-500 @enderror"
                value="{{ old('solicitado_por') }}"
                placeholder="Nombre de quien solicita">
            @error('solicitado_por')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Autorizado por -->
        <div class="space-y-2">
            <label class="block text-sm font-medium text-[#002c5f] flex items-center gap-2">
                <i class="ph ph-user-circle-gear text-[#b79a37]"></i>
                Autorizado por
            </label>
            <input type="text" name="autorizado_por"
                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-[#b79a37]/40 focus:border-[#b79a37] focus:outline-none transition duration-200
                @error('autorizado_por') border-red-500 @enderror"
                value="{{ old('autorizado_por') }}"
                placeholder="Nombre de quien autoriza">
            @error('autorizado_por')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Documento -->
        <div class="space-y-2">
            <label class="block text-sm font-medium text-[#002c5f] flex items-center gap-2">
                <i class="ph ph-file-text text-[#b79a37]"></i>
                Documento (PDF o imagen)
                <span class="text-red-500">*</span>
            </label>
            <div class="mt-1 flex flex-col sm:flex-row items-start sm:items-center gap-4">
                <label for="documento" class="cursor-pointer w-full sm:w-auto">
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-[#002c5f] transition duration-200 group bg-gray-50">
                        <i class="ph ph-cloud-arrow-up text-3xl text-gray-400 group-hover:text-[#002c5f] mb-2 animate__animated animate__fadeIn"></i>
                        <p class="text-sm text-gray-600">Haga clic para seleccionar un archivo</p>
                        <p class="text-xs text-gray-500 mt-1">Formatos: PDF, JPG, PNG (máx. 5MB)</p>
                    </div>
                    <input id="documento" name="documento" type="file" class="sr-only" accept=".pdf,.jpg,.jpeg,.png">
                </label>
                <div class="flex flex-col gap-2">
                    <div id="fileName" class="text-sm text-gray-700 font-medium hidden"></div>
                    <button type="button" id="removeFileBtn" class="hidden px-3 py-1 rounded bg-red-100 text-red-600 text-xs hover:bg-red-200 transition duration-200 flex items-center gap-1">
                        <i class="ph ph-trash"></i> Quitar archivo
                    </button>
                </div>
            </div>
            <div id="previewContainer" class="mt-2"></div>
            @error('documento')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Botones -->
        <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
            <a href="{{ route('referencias.index') }}"
                class="px-5 py-2.5 rounded-lg border border-gray-300 text-[#002c5f] bg-white hover:bg-gray-50 transition duration-200 flex items-center gap-2 font-medium focus:outline-none">
                <i class="ph ph-x"></i>
                Cancelar
            </a>
            <button type="submit"
                class="px-5 py-2.5 rounded-lg bg-gradient-to-r from-[#002c5f] to-[#b79a37] text-white hover:opacity-90 transition duration-200 flex items-center gap-2 shadow-md font-semibold focus:outline-none">
                <i class="ph ph-floppy-disk"></i>
                Guardar Referencia
            </button>
        </div>
    </form>
</div>

@section('fab')
    <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
        class="fixed bottom-8 right-8 z-50 p-3 bg-[#002c5f] text-white rounded-full shadow-lg hover:bg-[#b79a37] transition duration-200 group focus:outline-none"
        title="Volver arriba" aria-label="Volver arriba">
        <i class="ph ph-arrow-up text-xl group-hover:animate-bounce"></i>
    </button>
@endsection

<script>
    // Vista previa y nombre del archivo seleccionado
    const documentoInput = document.getElementById('documento');
    const fileNameDisplay = document.getElementById('fileName');
    const previewContainer = document.getElementById('previewContainer');
    const removeFileBtn = document.getElementById('removeFileBtn');

    documentoInput.addEventListener('change', function() {
        previewContainer.innerHTML = '';
        if (this.files.length > 0) {
            const file = this.files[0];
            fileNameDisplay.textContent = file.name;
            fileNameDisplay.classList.remove('hidden');
            removeFileBtn.classList.remove('hidden');

            // Animación
            fileNameDisplay.classList.add('animate__animated', 'animate__fadeInRight');

            // Vista previa para imágenes
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewContainer.innerHTML = `<img src="${e.target.result}" alt="Vista previa" class="max-h-40 rounded shadow border mx-auto animate__animated animate__fadeInUp">`;
                };
                reader.readAsDataURL(file);
            } else if (file.type === 'application/pdf') {
                // Vista previa para PDF
                previewContainer.innerHTML = `<embed src="${URL.createObjectURL(file)}" type="application/pdf" class="w-full max-h-40 rounded shadow border animate__animated animate__fadeInUp" />`;
            } else {
                previewContainer.innerHTML = '';
            }
        } else {
            fileNameDisplay.classList.add('hidden');
            removeFileBtn.classList.add('hidden');
            previewContainer.innerHTML = '';
        }
    });

    // Quitar archivo seleccionado
    removeFileBtn.addEventListener('click', function() {
        documentoInput.value = '';
        fileNameDisplay.textContent = '';
        fileNameDisplay.classList.add('hidden');
        previewContainer.innerHTML = '';
        removeFileBtn.classList.add('hidden');
    });

    // Validación antes de enviar
    document.getElementById('referenciaForm').addEventListener('submit', function(e) {
        const requiredFields = ['autorizado_por', 'solicitado_por'];
        let isValid = true;

        requiredFields.forEach(field => {
            const input = document.querySelector(`[name="${field}"]`);
            if (!input.value) {
                input.classList.add('border-red-500');
                isValid = false;
            } else {
                input.classList.remove('border-red-500');
            }
        });

        if (!isValid) {
            e.preventDefault();
            if (typeof showNotification === 'function') {
                showNotification('Por favor complete todos los campos requeridos', 'error');
            } else {
                alert('Por favor complete todos los campos requeridos');
            }
        }
    });
</script>
@endsection