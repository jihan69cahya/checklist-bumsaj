@extends('checklist')

@section('checklist-title', 'Curbside Area')

@section('checklist-content')
    <h1 class="mb-2 text-2xl font-bold">Checklist Curbside Area</h1>
    <p class="font-bold text-gray-700">Kamis, 13 Februari 2025</p>

    <div class="mt-4">
        <button class="flex items-center px-4 py-2 text-black bg-gray-300 rounded">
            Periode 2 07:00 - 09:00
            <span class="ml-2">▼</span>
        </button>
    </div>
    <table class="w-full border border-collapse border-gray-300 table-auto mt-4">
        <thead>
            <tr>
                <th class="px-4 py-2 border border-gray-300">Ruangan</th>
                <th class="px-4 py-2 border border-gray-300">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($checklist_items as $subcategory_id => $subcategory_items)
                @php
                    $subcategory_name = $subcategory_items->first()->subcategory->subcategory_name;
                @endphp

                <tr>
                    <td class="px-4 py-2 font-semibold bg-gray-200" colspan="4">
                        {{ $subcategory_name }}
                    </td>
                </tr>

                @foreach ($subcategory_items as $item)
                    <tr>
                        <td class="px-4 py-2 border border-gray-300">{{ $item->item_name }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $item->keterangan ?? '' }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
@endsection
