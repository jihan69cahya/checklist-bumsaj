@extends('checklist')

@section('checklist-title', 'Fasilitas Gedung Terminal')

@section('checklist-content')
    <h1 class="mb-2 text-2xl font-bold">Checklist Fasilitas Terminal</h1>
    <p class="font-bold text-gray-700">Kamis, 13 Februari 2025</p>

    <div class="relative mt-4">
        <button class="flex items-center px-4 py-2 text-black bg-gray-300 rounded" id="period-dropdown-button">
            Pilih Periode
            <span class="ml-2">▼</span>
        </button>
        <div class="absolute hidden mt-2 bg-white border border-gray-300 rounded shadow-lg" id="period-dropdown-menu">
            @foreach ($periods as $period)
                <a class="block px-4 py-2 text-gray-700 hover:bg-gray-100" data-period-id="{{ $period->id }}"
                    href="#">
                    {{ $period->label }}: {{ $period->start_time }} - {{ $period->end_time }}
                </a>
            @endforeach
        </div>
    </div>

    <table class="w-full mt-4 border border-collapse border-gray-300 table-auto">
        <thead>
            <tr>
                <th class="px-4 py-2 border border-gray-300" rowspan="2">Ruangan</th>
                <th class="px-4 py-2 border border-gray-300" colspan="{{ count($entry_values) }}">Kondisi</th>
                <th class="px-4 py-2 border border-gray-300" rowspan="2">Keterangan</th>
            </tr>
            <tr>
                @foreach ($entry_values as $entry_value)
                    <th class="border border-gray-300">{{ $entry_value->value_code }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($checklist_items as $checklist_subcategory_id => $checklist_subcategory_items)
                @php
                    $subcategory_name = $checklist_subcategory_items->first()->checklist_subcategory->name;
                @endphp

                <tr>
                    <td class="px-4 py-2 font-semibold bg-gray-200" colspan="{{ 2 + count($entry_values) }}">
                        {{ $subcategory_name }}
                    </td>
                </tr>

                @foreach ($checklist_subcategory_items as $item)
                    <tr>
                        <td class="px-4 py-2 border border-gray-300">{{ $item->name }}</td>
                        @foreach ($entry_values as $entry_value)
                            <td class="border border-gray-300">
                                <!-- Add a radio button for each entry value -->
                                <input class="flex justify-center w-full entry-value-radio"
                                    name="entry_value_{{ $item->id }}" data-item-id="{{ $item->id }}"
                                    data-entry-value-id="{{ $entry_value->id }}" type="radio"
                                    value="{{ $entry_value->id }}">
                            </td>
                        @endforeach
                        <td class="px-4 py-2 border border-gray-300">
                            {{ $item->keterangan }}
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    <script>
        document.getElementById('period-dropdown-button').addEventListener('click', function() {
            const dropdownMenu = document.getElementById('period-dropdown-menu');
            dropdownMenu.classList.toggle('hidden');
        });

        document.querySelectorAll('#period-dropdown-menu a').forEach(function(link) {
            link.addEventListener('click', function(event) {
                event.preventDefault();

                const periodId = this.getAttribute('data-period-id');
                const periodText = this.textContent;

                document.getElementById('period-dropdown-button').innerHTML = `
                    ${periodText}
                    <span class="ml-2">▼</span>
                `;

                document.getElementById('period-dropdown-menu').classList.add('hidden');

                fetchTableData(periodId);
            });
        });

        document.querySelectorAll('.entry-value-radio').forEach(radio => {
            radio.addEventListener('change', function() {
                const itemId = this.getAttribute('data-item-id');
                const entryValueId = this.getAttribute('data-entry-value-id');

                saveEntryValue(itemId, entryValueId);
            });
        });

        function saveEntryValue(itemId, entryValueId) {
            console.log(itemId, entryValueId);
            // axios.post('/checklist/save-entry-value', {
            //     item_id: itemId,
            //     entry_value_id: entryValueId
            // })
            // .then(response => {
            //     console.log('Entry value saved:', response.data);
            // })
            // .catch(error => {
            //     console.error('Error saving entry value:', error);
            // });
        }

        function fetchTableData(periodId) {
            axios.get(`/checklist/data?period_id=${periodId}`)
                .then(response => {
                    const data = response.data;

                    const tbody = document.querySelector('table tbody');
                    tbody.innerHTML = '';

                    data.checklist_items.forEach((subcategoryItems, subcategoryId) => {
                        const subcategoryName = subcategoryItems[0].subcategory.name; // Updated column name

                        tbody.innerHTML += `
                            <tr>
                                <td class="px-4 py-2 font-semibold bg-gray-200" colspan="${2 + data.entry_values.length}">
                                    ${subcategoryName}
                                </td>
                            </tr>
                        `;

                        subcategoryItems.forEach(item => {
                            tbody.innerHTML += `
                                <tr>
                                    <td class="px-4 py-2 border border-gray-300">${item.name}</td> <!-- Updated column name -->
                                    ${data.entry_values.map(entryValue => `
                                                                                                                                                        <td class="border border-gray-300"></td>
                                                                                                                                                    `).join('')}
                                    <td class="px-4 py-2 border border-gray-300">${item.keterangan || ''}</td>
                                </tr>
                            `;
                        });
                    });
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        }
    </script>
@endsection
