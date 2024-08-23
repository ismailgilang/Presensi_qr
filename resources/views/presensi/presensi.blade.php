<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Presensi') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="text-gray-900">
                    <!-- QR Code Scanner -->
                    <div class="flex justify-center items-center" style="padding:20px">
                        <div class="flex">
                            <div id="camera" style="width: 100%; height: 400px; border-radius: 20px;"></div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div id="qrModal" class="modal">
                        <div class="modal-content">
                            <span class="close">&times;</span>
                            <h2>Presensi</h2>
                            <form id="presensiForm" action="{{ route('Presensi2.store') }}" method="POST">
                                @csrf
                                <div class="mb-4 mt-4">
                                    <label for="name">Nama</label>
                                    <input type="text" id="name" name="name" class="w-full p-2 border border-gray-300 rounded mt-1" value="{{ $user->name }}" readonly>
                                </div>
                                <div class="mb-4">
                                    <label for="nip">NIP</label>
                                    <input type="text" id="nip" name="nip" class="w-full p-2 border border-gray-300 rounded mt-1" value="{{ $user->nip }}" readonly>
                                </div>
                                <div class="mb-4">
                                    <label for="role">Role</label>
                                    <input type="text" id="role" name="role" class="w-full p-2 border border-gray-300 rounded mt-1" value="{{ $user->role }}" readonly>
                                </div>
                                <div class="mb-4">
                                    <input type="hidden" id="qr" name="qr" class="w-full p-2 border border-gray-300 rounded mt-1" readonly>
                                </div>
                                <div class="mb-4">
                                    <label for="keterangan">Keterangan</label>
                                    <select id="keterangan" name="keterangan" class="w-full p-2 border border-gray-300 rounded mt-1">
                                        <option value="" disabled selected>Pilih Status</option>
                                        <option value="masuk">Masuk</option>
                                        <option value="pulang">Pulang</option>
                                    </select>
                                </div>
                                <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600 transition-colors">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include jsQR -->
    <script src="https://unpkg.com/jsqr/dist/jsQR.js"></script>

    <!-- Custom Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const video = document.createElement('video');
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');
            const qrModal = document.getElementById('qrModal');
            const closeModalButton = document.querySelector('#qrModal .close');
            const presensiForm = document.getElementById('presensiForm');
            const qrCodeInput = document.getElementById('qr');

            document.getElementById('camera').appendChild(video);
            canvas.width = 640;
            canvas.height = 480;

            function startCamera() {
                navigator.mediaDevices.getUserMedia({
                        video: {
                            facingMode: 'environment'
                        }
                    })
                    .then(stream => {
                        video.srcObject = stream;
                        video.setAttribute('playsinline', true);
                        video.play();
                        scanQRCode();
                    })
                    .catch(err => {
                        console.error('Error accessing camera: ', err);
                    });
            }

            function scanQRCode() {
                setInterval(() => {
                    if (video.readyState === video.HAVE_ENOUGH_DATA) {
                        context.drawImage(video, 0, 0, canvas.width, canvas.height);
                        const imageData = context.getImageData(0, 0, canvas.width, canvas.height);

                        // Use jsQR to decode QR code
                        const code = jsQR(imageData.data, canvas.width, canvas.height);

                        if (code) {
                            qrCodeInput.value = code.data;
                            qrModal.classList.add('show');
                        }
                    }
                }, 1000);
            }

            closeModalButton.addEventListener('click', function() {
                qrModal.classList.remove('show');
            });

            presensiForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Create FormData object from the form
                const formData = new FormData(presensiForm);

                // Submit form data via AJAX
                fetch('{{ route("Presensi2.store") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Close modal only on successful form submission
                            qrModal.classList.remove('show');
                            // Optionally, you can refresh the page or show a success message
                            alert('Data berhasil ditambahkan!');
                        } else {
                            // Show error message
                            alert('QR code tidak ditemukan.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });

            startCamera();
        });
    </script>
</x-app-layout>