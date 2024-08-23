<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Barcode Show') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Card Container -->
                    <div class="max-w-sm mx-auto bg-white rounded-lg shadow-md overflow-hidden">
                        <!-- Card Image -->
                        <div class="flex justify-center mt-4">
                            <img src="{{ $qrCodeUrl }}" alt="QR Code Image" class="w-48 h-48 object-cover mt-4">
                        </div>
                        <!-- Card Body -->
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4 text-center">Barcode Details</h3>
                            <div class="mb-4">
                                <p class="text-center"><strong>Judul:</strong> {{ $barcode->judul }}</p>
                                <p class="text-center"><strong>Deskripsi:</strong> {{ $barcode->deskripsi }}</p>
                                <p class="text-center"><strong>Keterangan:</strong> {{ $barcode->keterangan }}</p>
                                <p class="text-center"><strong>Dibuat:</strong> {{ $barcode->created_at->format('d-m-Y H:i:s') }}</p>
                            </div>
                            <div class="mt-4 text-center">
                                <a href="{{ route('Barcode.index') }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600">Back to List</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>