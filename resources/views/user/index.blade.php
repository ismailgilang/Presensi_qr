<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Add Button -->
                    <div class="flex justify-between mb-8">
                        <div class="mb-4 flex justify-start">
                            <p class="py-3 text-base font-medium text-gray-900 uppercase tracking-wider text-center"> Data Users</p>
                        </div>
                        <div class="mb-4 flex justify-start">
                            <button id="openModalButton" class="inline-block bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600">
                                +
                            </button>
                        </div>
                    </div>
                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table id="barcodeTable" class="min-w-full w-full divide-y divide-gray-200 text-center">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-900 uppercase tracking-wider text-center">No</th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-900 uppercase tracking-wider text-center">Nama</th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-900 uppercase tracking-wider text-center">Email</th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-900 uppercase tracking-wider text-center">Role</th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-900 uppercase tracking-wider text-center">Dibuat</th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-900 uppercase tracking-wider text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($data as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-left">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-left">{{ $item->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-left">{{ $item->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-left">{{ $item->role }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-left">{{ $item->created_at->format('d-m-Y H:i:s') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-left">
                                        <div class="flex gap-2">
                                            <a href="{{ route('User.edit', $item->id) }}" class="inline-block text-black px-4 py-2 rounded shadow" style="background-color:#FFFF00;">
                                                Edit
                                            </a>
                                            <form action="{{ route('User.destroy', $item->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-block bg-red-600 text-white px-4 py-2 rounded shadow focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Modal -->
                    <div id="modalBackdrop" class="fixed inset-0 bg-black opacity-50 z-40 hidden"></div>
                    <div id="addDataModal" class="fixed inset-0 flex items-center justify-center z-50 hidden opacity-0 transition-opacity duration-300">
                        <div class="bg-white p-6 rounded shadow-lg max-w-sm w-full transform scale-95 transition-transform duration-300">
                            <h3 class="text-lg font-semibold mb-4">Tambah Data</h3>
                            <!-- Modal Form -->
                            <form action="{{ route('User.store') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                                    <input type="text" id="name" name="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('name') }}" required>
                                    @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" id="email" name="email" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('email') }}" required>
                                    @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                    <input type="text" id="password" name="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('password') }}" required>
                                    @error('password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700" for="select-option">
                                        Pilih Role
                                    </label>
                                    <select name="role" id="select-option" class="mt-1 block w-full bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        <option value="" disabled selected>Pilih salah satu</option>
                                        <option value="admin">Admin</option>
                                        <option value="karyawan">Karyawan</option>
                                    </select>
                                </div>
                                <div class="flex justify-end gap-4">
                                    <button type="button" id="closeModalButton" class="inline-block bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600">Cancel</button>
                                    <button type="submit" class="inline-block bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#barcodeTable').DataTable({
                // DataTables options can be added here if needed
                paging: true, // Enable pagination
                searching: true, // Enable search
                lengthChange: true // Enable page length selection
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const openModalButton = document.getElementById('openModalButton');
            const closeModalButton = document.getElementById('closeModalButton');
            const addDataModal = document.getElementById('addDataModal');
            const modalBackdrop = document.getElementById('modalBackdrop');

            openModalButton.addEventListener('click', function() {
                modalBackdrop.classList.remove('hidden');
                addDataModal.classList.remove('hidden');
                setTimeout(() => {
                    addDataModal.classList.remove('opacity-0');
                    addDataModal.classList.add('opacity-100');
                    addDataModal.classList.add('scale-100');
                }, 10); // Delay to ensure transition is applied
            });

            closeModalButton.addEventListener('click', function() {
                addDataModal.classList.remove('opacity-100');
                addDataModal.classList.add('opacity-0');
                addDataModal.classList.add('scale-95');
                setTimeout(() => {
                    addDataModal.classList.add('hidden');
                    modalBackdrop.classList.add('hidden');
                }, 300); // Matches the duration of the transition
            });

            modalBackdrop.addEventListener('click', function() {
                closeModalButton.click();
            });
        });
    </script>
</x-app-layout>