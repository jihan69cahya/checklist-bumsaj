@extends('layouts.app')

@section('title', 'Rekapitulasi')

@section('content')
    <h1 class="text-2xl font-bold">Rekapitulasi</h1>

    <div class="flex gap-4 mt-4">
        <div class="flex items-center gap-2">
            <label for="startDate">Dari:</label>
            <input class="px-4 py-2 bg-gray-200 rounded-md" id="startDate" type="date"
                value="{{ request('start_date', today()->format('Y-m-d')) }}">
        </div>

        <div class="flex items-center gap-2">
            <label for="endDate">Sampai:</label>
            <input class="px-4 py-2 bg-gray-200 rounded-md" id="endDate" type="date"
                value="{{ request('end_date', today()->format('Y-m-d')) }}">
        </div>

        <select class="px-4 py-2 bg-gray-200 rounded-md" id="categorySelect">
            <option value="1" {{ $categoryId == 1 ? 'selected' : '' }}>Fasilitas Terminal</option>
            <option value="2" {{ $categoryId == 2 ? 'selected' : '' }}>Kebersihan Terminal</option>
            <option value="3" {{ $categoryId == 3 ? 'selected' : '' }}>Curbside Area</option>
        </select>

        <button class="px-4 py-2 text-white bg-blue-600 rounded-md" id="filterBtn">Filter</button>
    </div>
    <table class="w-full mt-6 border border-collapse">
        <thead>
            <tr class="bg-gray-200">
                <th class="px-4 py-2 border">Nama Ruangan</th>
                @foreach ($entry_values as $entry_value)
                    <th class="px-4 py-2 border">{{ $entry_value->value_code }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($subcategories as $subcategory)
                <tr>
                    <td class="px-4 py-2 border">{{ $subcategory->name }}</td>

                    @if ($categoryId == 1)
                        <td class="px-4 py-2 border">{{ $entries[$subcategory->id][1] ?? 0 }}</td>
                        <td class="px-4 py-2 border">{{ $entries[$subcategory->id][2] ?? 0 }}</td>
                    @elseif ($categoryId == 2)
                        <td class="px-4 py-2 border">{{ $entries[$subcategory->id][3] ?? 0 }}</td>
                        <td class="px-4 py-2 border">{{ $entries[$subcategory->id][4] ?? 0 }}</td>
                        <td class="px-4 py-2 border">{{ $entries[$subcategory->id][5] ?? 0 }}</td>
                    @elseif ($categoryId == 3)
                        <td class="px-4 py-2 border">{{ $entries[$subcategory->id][6] ?? 0 }}</td>
                        <td class="px-4 py-2 border">{{ $entries[$subcategory->id][7] ?? 0 }}</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Tombol Download -->
    <button class="flex items-center gap-2 px-4 py-2 mt-6 text-white bg-blue-600 rounded-md">
        <span class="fa-solid fa-download"></span>
        Download Rekapitulasi
    </button>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
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
