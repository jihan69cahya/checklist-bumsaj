@extends('checklist')

@section('checklist-title', 'Fasilitas Gedung Terminal')

@section('checklist-content')
    <h1 class="mb-2 text-2xl font-bold">Checklist Fasilitas Terminal</h1>
    <p class="font-bold text-gray-700">Kamis, 13 Februari 2025</p>

    <div class="relative mt-4">
        <button class="flex items-center px-4 py-2 text-black bg-gray-300 rounded" id="period-dropdown-button">
            Pilih Periode <!-- Default placeholder -->
            <span class="ml-2">▼</span>
        </button>
        <div class="absolute hidden mt-2 bg-white border border-gray-300 rounded shadow-lg" id="period-dropdown-menu">
            @foreach ($periods as $period)
                <a class="block px-4 py-2 text-gray-700 hover:bg-gray-100" data-period-id="{{ $period->id }}"
                    href="#">
                    {{ $period->period_label }}: {{ $period->period_start_time }} - {{ $period->period_end_time }}
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
            @foreach ($checklist_items as $subcategory_id => $subcategory_items)
                @php
                    $subcategory_name = $subcategory_items->first()->subcategory->subcategory_name;
                @endphp

                <tr>
                    <td class="px-4 py-2 font-semibold bg-gray-200" colspan="{{ 2 + count($entry_values) }}">
                        {{ $subcategory_name }}
                    </td>
                </tr>

                @foreach ($subcategory_items as $item)
                    <tr>
                        <td class="px-4 py-2 border border-gray-300">{{ $item->item_name }}</td>
                        @foreach ($entry_values as $entry_value)
                            <td class="border border-gray-300"></td>
                        @endforeach
                        <td class="px-4 py-2 border border-gray-300">{{ $item->keterangan ?? '' }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
    <script>
        // Toggle dropdown visibility
        document.getElementById('period-dropdown-button').addEventListener('click', function() {
            const dropdownMenu = document.getElementById('period-dropdown-menu');
            dropdownMenu.classList.toggle('hidden');
        });

        // Handle period selection
        document.querySelectorAll('#period-dropdown-menu a').forEach(function(link) {
            link.addEventListener('click', function(event) {
                event.preventDefault();

                // Get the selected period ID and text
                const periodId = this.getAttribute('data-period-id');
                const periodText = this.textContent;

                // Update the button text
                document.getElementById('period-dropdown-button').innerHTML = `
                    ${periodText}
                    <span class="ml-2">▼</span>
                `;

                // Close the dropdown
                document.getElementById('period-dropdown-menu').classList.add('hidden');

                // Fetch and update table data based on the selected period
                fetchTableData(periodId);
            });
        });

        // Function to fetch and update table data using Axios
        function fetchTableData(periodId) {
            // Make an AJAX request to fetch data for the selected period
            axios.get(`/checklist/data?period_id=${periodId}`)
                .then(response => {
                    const data = response.data;

                    // Clear the existing table rows
                    const tbody = document.querySelector('table tbody');
                    tbody.innerHTML = '';

                    // Loop through the new data and add rows to the table
                    data.checklist_items.forEach((subcategoryItems, subcategoryId) => {
                        const subcategoryName = subcategoryItems[0].subcategory.subcategory_name;

                        // Add subcategory row
                        tbody.innerHTML += `
                            <tr>
                                <td class="px-4 py-2 font-semibold bg-gray-200" colspan="${2 + data.entry_values.length}">
                                    ${subcategoryName}
                                </td>
                            </tr>
                        `;

                        // Add checklist items
                        subcategoryItems.forEach(item => {
                            tbody.innerHTML += `
                                <tr>
                                    <td class="px-4 py-2 border border-gray-300">${item.item_name}</td>
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
