@extends('checklist')

@section('checklist-title', 'Kebersihan Gedung Terminal')

@section('checklist-content')
    <h1 class="mb-2 text-2xl font-bold">Checklist Kebersihan Terminal</h1>
    <p class="font-bold text-gray-700">Kamis, 13 Februari 2025</p>

    <div class="fixed z-10 top-0 hidden p-4 px-8 py-4 mt-4 text-center text-black transform -translate-x-1/2 bg-white border-[1px] border-blue-600 rounded-full shadow-md left-1/2"
        id="snackbar">
        <span>Anda memiliki perubahan yang belum disimpan.</span>
        <button class="px-3 py-2 ml-4 text-sm text-white bg-blue-600 rounded-full hover:bg-blue-700"
            id="snackbar-button">Submit
            Sekarang</button>
    </div>

    <div class="relative mt-4">
        <button class="flex items-center px-4 py-2 text-black bg-gray-300 rounded" id="period-dropdown-button">
            Pilih Periode
            <span class="ml-2">▼</span>
        </button>
        <div class="absolute hidden mt-2 bg-white border border-gray-300 rounded shadow-lg" id="period-dropdown-menu">
            @foreach ($periods as $period)
                <a class="block px-4 py-2 text-gray-700 hover:bg-gray-100" data-period-id="{{ $period->id }}"
                    data-start-time="{{ $period->start_time }}" data-end-time="{{ $period->end_time }}" href="#">
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

    <button class="px-4 py-2 mt-4 text-white bg-blue-500 rounded" id="submit-button">Submit</button>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const snackbar = document.getElementById('snackbar');
            const snackbarButton = document.getElementById('snackbar-button');

            // Show snackbar when a radio button is clicked
            document.querySelectorAll('.entry-value-radio').forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.checked) {
                        snackbar.classList.remove('hidden');
                    }
                });
            });

            snackbarButton.addEventListener('click', function() {
                document.getElementById('submit-button').scrollIntoView({
                    behavior: 'smooth'
                });
            });

            document.getElementById('period-dropdown-button').addEventListener('click', function() {
                const dropdownMenu = document.getElementById('period-dropdown-menu');
                dropdownMenu.classList.toggle('hidden');
            });

            document.querySelectorAll('#period-dropdown-menu a').forEach(function(link) {
                link.addEventListener('click', function(event) {
                    event.preventDefault();

                    const periodId = this.getAttribute('data-period-id');
                    const periodText = this.textContent;

                    const dropdownButton = document.getElementById('period-dropdown-button');
                    dropdownButton.innerHTML = `
                        ${periodText}
                        <span class="ml-2">▼</span>
                    `;
                    dropdownButton.setAttribute('data-period-id', periodId);

                    document.getElementById('period-dropdown-menu').classList.add('hidden');

                    fetchTableData(periodId);
                });
            });

            document.getElementById('submit-button').addEventListener('click', function() {
                const periodId = document.getElementById('period-dropdown-button').getAttribute(
                    'data-period-id');

                if (!periodId) {
                    console.error('No period selected.');
                    return;
                }

                const now = new Date();
                const entryDate = now.toISOString().split('T')[0];
                const entryTime = now.toTimeString().split(' ')[0];

                const entries = [];
                document.querySelectorAll('.entry-value-radio:checked').forEach(radio => {
                    const itemId = radio.getAttribute('data-item-id');
                    const entryValueId = radio.getAttribute('data-entry-value-id');

                    entries.push({
                        item_id: itemId,
                        entry_value_id: entryValueId,
                        period_id: periodId,
                        entry_date: entryDate,
                        entry_time: entryTime,
                    });
                });

                axios.post('/checklist/save-entry-values', {
                        entries
                    })
                    .then(response => {
                        console.log('Entry values saved:', response.data);
                        snackbar.classList.add('hidden');
                    })
                    .catch(error => {
                        console.error('Error saving entry values:', error);
                        alert('Terjadi kesalahan saat menyimpan data.');
                    });
            });

            function fetchTableData(periodId) {
                const categoryId = {{ $category_id }};
                const entryDate = new Date().toISOString().split('T')[0]; // Get current date
                const params = {
                    checklist_category_id: categoryId,
                    entry_date: entryDate,
                    period_id: periodId
                };

                document.querySelectorAll('.entry-value-radio').forEach(radio => {
                    radio.checked = false;
                });

                axios.get('/checklist/entries-by-period', {
                        params
                    })
                    .then(response => {
                        const entries = response.data;
                        console.log(entries);

                        entries.forEach(entry => {
                            const itemId = entry.checklist_item_id;
                            const entryValueId = entry.entry_value_id;

                            const radioButton = document.querySelector(
                                `.entry-value-radio[data-item-id="${itemId}"][data-entry-value-id="${entryValueId}"]`
                            );
                            if (radioButton) {
                                radioButton.checked = true;
                            }
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching entries:', error);
                    });
            }

            function getCurrentPeriod() {
                const now = new Date();
                const currentHour = now.getHours();
                const currentMinute = now.getMinutes();
                const currentTime = currentHour * 60 + currentMinute;

                let selectedPeriod = null;

                document.querySelectorAll('#period-dropdown-menu a').forEach(link => {
                    const startTime = link.getAttribute('data-start-time');
                    const endTime = link.getAttribute('data-end-time');

                    const startHour = parseInt(startTime.split(':')[0]);
                    const startMinute = parseInt(startTime.split(':')[1]);
                    const startTotal = startHour * 60 + startMinute;

                    const endHour = parseInt(endTime.split(':')[0]);
                    const endMinute = parseInt(endTime.split(':')[1]);
                    const endTotal = endHour * 60 + endMinute;

                    if (currentTime >= startTotal && currentTime <= endTotal) {
                        selectedPeriod = link;
                    }
                });

                if (selectedPeriod) {
                    selectedPeriod.click();
                }
            }

            getCurrentPeriod();
        });
    </script>
@endsection
