<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Presensi') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between mb-8">
                        <div class="mb-4 flex justify-start">
                            <p class="py-3 text-base font-medium text-gray-900 uppercase tracking-wider text-center">Data Presensi Anda</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table id="barcodeTable" class="min-w-full w-full divide-y divide-gray-200 text-center">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-900 uppercase tracking-wider text-center">No</th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-900 uppercase tracking-wider text-center">NIP</th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-900 uppercase tracking-wider text-center">Nama</th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-900 uppercase tracking-wider text-center">Role</th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-900 uppercase tracking-wider text-center">Judul</th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-900 uppercase tracking-wider text-center">Dibuat</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($presensiData as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-left">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-left">{{ $item->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-left">{{ $item->nip }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-left">{{ $item->role }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-left">
                                        {{ $barcodeTitles[$item->qr] ?? 'Unknown' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-left">
                                        {{ $item->created_at->format('d-m-Y H:i:s') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
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
    </script>
</x-app-layout>