@extends('layouts.app')

@section('title', 'Rekapitulasi')

@section('content')
    <h1 class="text-2xl font-bold">Rekapitulasi</h1>

    <div class="flex gap-4 mt-4">
        <!-- Pilih Start Date -->
        <div class="flex items-center gap-2">
            <label for="startDate">Dari:</label>
            <input type="date" id="startDate" class="bg-gray-200 px-4 py-2 rounded-md" value="{{ request('start_date', today()->format('Y-m-d')) }}">
        </div>

        <!-- Pilih End Date -->
        <div class="flex items-center gap-2">
            <label for="endDate">Sampai:</label>
            <input type="date" id="endDate" class="bg-gray-200 px-4 py-2 rounded-md" value="{{ request('end_date', today()->format('Y-m-d')) }}">
        </div>

        <!-- Pilih Kategori -->
        <select id="categorySelect" class="bg-gray-200 px-4 py-2 rounded-md">
            <option value="1" {{ $categoryId == 1 ? 'selected' : '' }}>Fasilitas Terminal</option>
            <option value="2" {{ $categoryId == 2 ? 'selected' : '' }}>Kebersihan Terminal</option>
            <option value="3" {{ $categoryId == 3 ? 'selected' : '' }}>Curbside Area</option>
        </select>

        <!-- Tombol Filter -->
        <button id="filterBtn" class="bg-blue-600 text-white px-4 py-2 rounded-md">Filter</button>
    </div>

    <!-- Tabel Rekapitulasi -->
    <table class="mt-6 w-full border border-collapse">
        <thead>
            <tr class="bg-gray-200">
                <th class="border px-4 py-2">Nama Ruangan</th>
                @if ($categoryId == 1)
                    <th class="border px-4 py-2">B</th>
                    <th class="border px-4 py-2">RK</th>
                @elseif ($categoryId == 2)
                    <th class="border px-4 py-2">B</th>
                    <th class="border px-4 py-2">KB</th>
                    <th class="border px-4 py-2">K</th>
                @elseif ($categoryId == 3)
                    <th class="border px-4 py-2">P</th>
                    <th class="border px-4 py-2">L</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($subcategories as $subcategory)
                <tr>
                    <td class="border px-4 py-2">{{ $subcategory->subcategory_name }}</td>

                    @if ($categoryId == 1)
                        <td class="border px-4 py-2">{{ $entries[$subcategory->id][1] ?? 0 }}</td>
                        <td class="border px-4 py-2">{{ $entries[$subcategory->id][2] ?? 0 }}</td>
                    @elseif ($categoryId == 2)
                        <td class="border px-4 py-2">{{ $entries[$subcategory->id][3] ?? 0 }}</td>
                        <td class="border px-4 py-2">{{ $entries[$subcategory->id][4] ?? 0 }}</td>
                        <td class="border px-4 py-2">{{ $entries[$subcategory->id][5] ?? 0 }}</td>
                    @elseif ($categoryId == 3)
                        <td class="border px-4 py-2">{{ $entries[$subcategory->id][6] ?? 0 }}</td>
                        <td class="border px-4 py-2">{{ $entries[$subcategory->id][7] ?? 0 }}</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Tombol Download -->
    <button class="mt-6 bg-blue-600 text-white px-4 py-2 rounded-md flex items-center gap-2">
        <span class="fa-solid fa-download"></span>
        Download Rekapitulasi
    </button>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            function updateRekapitulasi() {
                let startDate = document.getElementById("startDate").value;
                let endDate = document.getElementById("endDate").value;
                let selectedCategory = document.getElementById("categorySelect").value;

                let url = new URL(window.location.href);
                url.searchParams.set("start_date", startDate);
                url.searchParams.set("end_date", endDate);
                url.searchParams.set("category_id", selectedCategory);

                window.location.href = url.toString();
            }

            document.getElementById("filterBtn").addEventListener("click", updateRekapitulasi);
        });
    </script>
@endsection
