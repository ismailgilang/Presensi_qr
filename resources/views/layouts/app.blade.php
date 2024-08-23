<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <style>
        #camera {
            width: 100%;
            height: 400px;
            border-radius: 20px;
            overflow: hidden;
            /* Untuk memastikan border-radius diterapkan dengan benar */
        }

        #qrModal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        #qrModal.show {
            display: flex;
            opacity: 1;
        }

        #qrModal .modal-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            width: 80%;
            max-width: 500px;
            position: relative;
            transform: translateY(-50px);
            transition: transform 0.3s ease;
        }

        #qrModal.show .modal-content {
            transform: translateY(0);
        }

        #qrModal .close {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 1.5rem;
        }
    </style>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endisset

        <!-- Page Content -->
        <main>
            @if (session('success'))
            <div class="py-6">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
                    <div class="overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="text-gray-900">
                            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                                {{ session('success') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            {{ $slot }}
        </main>
    </div>
    <script>
        $(document).ready(function() {
            $('#masukTable').DataTable();
            $('#pulangTable').DataTable();
        });
    </script>
</body>

</html>