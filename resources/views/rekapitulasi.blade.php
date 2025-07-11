@extends('layouts.app')

@section('title', 'Rekapitulasi')

@section('content')
    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
        <h1 class="text-xl font-semibold text-gray-800">Rekapitulasi</h1>
        <p class="text-gray-600 text-sm leading-relaxed">
            Seluruh data checklist ditampilkan, namun dalam laporan rekapitulasi ini hanya disajikan data yang telah
            divalidasi oleh admin.
        </p>
    </div>

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
                    @foreach ($entry_values as $entry_value)
                        <td class="px-4 py-2 border">
                            {{ $entries[$subcategory->id][$entry_value->id] ?? 0 }}
                        </td>
                    @endforeach
                </tr>
            @endforeach

        </tbody>
    </table>

    <!-- Tombol Download -->
    <form action="{{ route('rekapitulasi.download') }}" method="GET">
        <input type="hidden" name="start_date" value="{{ request('start_date', today()->format('Y-m-d')) }}">
        <input type="hidden" name="end_date" value="{{ request('end_date', today()->format('Y-m-d')) }}">
        <input type="hidden" name="category_id" value="{{ request('category_id', 1) }}">

        <button type="submit" class="flex items-center gap-2 px-4 py-2 mt-6 text-white bg-blue-600 rounded-md">
            <span class="fa-solid fa-download"></span>
            Download Rekapitulasi
        </button>
    </form>




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

        document.getElementById("downloadCsvBtn").addEventListener("click", function() {
            let startDate = document.getElementById("startDate").value;
            let endDate = document.getElementById("endDate").value;
            let selectedCategory = document.getElementById("categorySelect").value;

            let url = new URL("{{ route('rekapitulasi.download') }}", window.location.origin);
            url.searchParams.set("start_date", startDate);
            url.searchParams.set("end_date", endDate);
            url.searchParams.set("category_id", selectedCategory);

            window.location.href = url.toString();
        });
    </script>
@endsection
