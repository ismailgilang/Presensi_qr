<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Presensi') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between mb-8">
                        <div class="mb-4 flex justify-start">
                            <p class="py-3 text-base font-medium text-gray-900 uppercase tracking-wider text-center">Data Presensi</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table id="barcodeTable" class="min-w-full w-full divide-y divide-gray-200 text-center">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-900 uppercase tracking-wider text-center">No</th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-900 uppercase tracking-wider text-center">Judul</th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-900 uppercase tracking-wider text-center">Dibuat</th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-900 uppercase tracking-wider text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($data as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-left">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-left">{{ $item->judul }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-left">{{ $item->created_at->format('d-m-Y H:i:s') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-left">
                                        <div class="flex gap-2">
                                            <button
                                                class="inline-block bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600 open-modal"
                                                data-judul="{{ $item->judul }}"
                                                data-id="{{ $item->id }}">
                                                Mulai Presensi
                                            </button>
                                            <a href="{{ route('Presensi.show', $item->id) }}" class="inline-block text-white px-4 py-2 rounded shadow" style="background-color:#32CD32;">
                                                Data Presensi
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div id="modalBackdrop" class="fixed inset-0 bg-black opacity-50 z-40 hidden"></div>
                    <div id="addDataModal" class="fixed inset-0 flex items-center justify-center z-50 hidden opacity-0 transition-opacity duration-300">
                        <div class="bg-white p-6 rounded shadow-lg max-w-sm w-full transform scale-95 transition-transform duration-300 relative">
                            <button id="closeModalButton" class="absolute top-2 right-2 bg-gray-300 text-gray-700 rounded-full px-3 py-1 hover:bg-gray-400">
                                &times;
                            </button>
                            <h3 class="text-lg font-semibold mb-4 text-center" id="modal-title">Scan Untuk Presensi</h3>
                            <div class="flex justify-center mt-4">
                                <img id="modal-qr-code" src="" alt="QR Code Image" class="w-48 h-48 object-cover mt-4">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#barcodeTable').DataTable({
                paging: true,
                searching: true,
                lengthChange: true
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const modalBackdrop = document.getElementById('modalBackdrop');
            const addDataModal = document.getElementById('addDataModal');
            const closeModalButton = document.getElementById('closeModalButton');
            let modalQrCode = document.getElementById('modal-qr-code');

            let qrCodeInterval;

            document.querySelectorAll('.open-modal').forEach(button => {
                button.addEventListener('click', function() {
                    const judul = this.getAttribute('data-judul');
                    const id = this.getAttribute('data-id');

                    document.getElementById('modal-title').textContent = `Scan Untuk Presensi: ${judul}`;
                    updateQRCode(id);

                    modalBackdrop.classList.remove('hidden');
                    addDataModal.classList.remove('hidden');
                    setTimeout(() => {
                        addDataModal.classList.remove('opacity-0');
                        addDataModal.classList.add('opacity-100');
                        addDataModal.classList.add('scale-100');
                    }, 10);

                    qrCodeInterval = setInterval(() => {
                        updateQRCode(id);
                    }, 10000);
                });
            });

            closeModalButton.addEventListener('click', function() {
                clearInterval(qrCodeInterval);
                addDataModal.classList.remove('opacity-100');
                addDataModal.classList.add('opacity-0');
                addDataModal.classList.add('scale-95');
                setTimeout(() => {
                    addDataModal.classList.add('hidden');
                    modalBackdrop.classList.add('hidden');
                }, 300);
            });

            modalBackdrop.addEventListener('click', function() {
                closeModalButton.click();
            });

            function updateQRCode(id) {
                const randomParam = Math.random().toString(36).substring(2, 9);
                const qrCodeSrc = `https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=${encodeURIComponent(id)}&random=${randomParam}`;

                const newQrCode = new Image();
                newQrCode.src = qrCodeSrc;
                newQrCode.classList.add('w-48', 'h-48', 'object-cover', 'mt-4');

                modalQrCode.parentNode.replaceChild(newQrCode, modalQrCode);
                modalQrCode = newQrCode;
            }
        });
    </script>
</x-app-layout>