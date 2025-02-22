@extends('layouts.app')

@section('title', 'rekapitulasi')

@section('content')
        <h1 class="text-2xl font-bold">Rekapitulasi</h1>

        <div class="flex gap-4 mt-4">
            <button id="dateBtn" class="bg-gray-200 px-4 py-2 rounded-md flex items-center gap-2">
                <span id="selectedDate">Kamis, 13 Februari 2025</span>
                <span class="fa-solid fa-calendar"></span>
            </button>

            <div class="relative">
                <button id="facilityBtn" class="bg-gray-200 px-4 py-2 rounded-md flex items-center gap-2">
                    <span id="selectedFacility">Fasilitas Terminal</span>
                    <span class="fa-solid fa-chevron-down"></span>
                </button>
  
                <ul id="facilityDropdown" class="absolute left-0 mt-2 w-48 bg-white shadow-md rounded-md hidden">
                    <li class="px-4 py-2 cursor-pointer hover:bg-gray-200" onclick="selectFacility('Fasilitas Terminal')">Fasilitas Terminal</li>
                    <li class="px-4 py-2 cursor-pointer hover:bg-gray-200" onclick="selectFacility('Kebersihan Terminal')">Kebersihan Terminal</li>
                    <li class="px-4 py-2 cursor-pointer hover:bg-gray-200" onclick="selectFacility('Curbside Area')">Curbside Area</li>
                </ul>
            </div>
        </div>

        <table class="mt-6 w-full border border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2">Nama Ruangan</th>
                    <th class="border px-4 py-2">B</th>
                    <th class="border px-4 py-2">RK</th>
                    <th class="border px-4 py-2">KB</th>
                    <th class="border px-4 py-2">K</th>
                    <th class="border px-4 py-2">P</th>
                    <th class="border px-4 py-2">L</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subcategories as $subcategory)
                    <tr>
                        <td class="border px-4 py-2">{{ $subcategory->subcategory_name }}</td>
                        <td class="border px-4 py-2">{{ $entries[$subcategory->id][1] ?? 0 }}</td>
                        <td class="border px-4 py-2">{{ $entries[$subcategory->id][2] ?? 0 }}</td>
                        <td class="border px-4 py-2">{{ $entries[$subcategory->id][4] ?? 0 }}</td>
                        <td class="border px-4 py-2">{{ $entries[$subcategory->id][5] ?? 0 }}</td>
                        <td class="border px-4 py-2">{{ $entries[$subcategory->id][6] ?? 0 }}</td>
                        <td class="border px-4 py-2">{{ $entries[$subcategory->id][7] ?? 0 }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button class="mt-6 bg-blue-600 text-white px-4 py-2 rounded-md flex items-center gap-2">
            <span class="fa-solid fa-download"></span>
            Download Rekapitulasi
        </button>

        <div id="dateCard" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-lg font-semibold mb-4">Pilih Tanggal</h2>
            <input type="date" id="datePicker" class="p-2 border border-gray-300 rounded-md w-full">
            <div class="flex justify-end gap-4 mt-4">
                <button id="closeDateCard" class="px-4 py-2 bg-red-500 text-white rounded-md">Batal</button>
                <button id="confirmDate" class="px-4 py-2 bg-blue-600 text-white rounded-md">Pilih</button>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("dateBtn").addEventListener("click", function() {
            document.getElementById("dateCard").classList.remove("hidden");
        });

        document.getElementById("closeDateCard").addEventListener("click", function() {
            document.getElementById("dateCard").classList.add("hidden");
        });

        document.getElementById("confirmDate").addEventListener("click", function() {
            let selectedDate = document.getElementById("datePicker").value;
            if (selectedDate) {
                document.getElementById("selectedDate").textContent = new Date(selectedDate).toLocaleDateString('id-ID', {
                    weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
                });
                document.getElementById("dateCard").classList.add("hidden");
            }
        });

        document.getElementById("facilityBtn").addEventListener("click", function() {
            document.getElementById("facilityDropdown").classList.toggle("hidden");
        });

        function selectFacility(name) {
            document.getElementById("selectedFacility").textContent = name;
            document.getElementById("facilityDropdown").classList.add("hidden");
        }
    </script>

@endsection
