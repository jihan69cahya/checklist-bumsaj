@extends('layouts.app')

@section('title')
    {{ $checklist_category->name }}
@endsection

@section('content')
    <h1 class="mb-2 text-2xl font-bold">Checklist {{ $checklist_category->name }}</h1>
    <p class="font-bold text-gray-700" id="current-date"></p>

    <div class="fixed z-20 flex items-center justify-between px-6 py-3 text-white transition-all duration-500 ease-in-out transform -translate-x-1/2 translate-y-5 bg-blue-600 shadow-lg opacity-0 bottom-5 left-1/2 rounded-xl"
        id="snackbar">
        <span>Anda memiliki perubahan yang belum disimpan.</span>
        <button class="px-4 py-2 ml-4 text-blue-600 transition-colors bg-white rounded-full hover:bg-gray-200"
            id="snackbar-button">Submit Sekarang</button>
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

    <button
        class="relative z-50 flex items-center justify-center w-full gap-2 px-4 py-2 mt-4 text-white transition duration-300 bg-blue-600 rounded-md shadow-md hover:bg-yellow-500 disabled:bg-gray-400 disabled:cursor-not-allowed"
        id="submit-button">
        <span id="submit-text">Simpan</span>
        <span class="hidden w-5 h-5 border-2 border-white rounded-full border-t-transparent animate-spin"
            id="submit-spinner"></span>
    </button>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date();
            const options = {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            };
            document.getElementById('current-date').innerText = today.toLocaleDateString('id-ID', options);


            const snackbar = document.getElementById('snackbar');
            const snackbarButton = document.getElementById('snackbar-button');
            const submitButton = document.getElementById('submit-button');
            let isChanged = false;

            function showSnackbar() {
                if (!isChanged) {
                    isChanged = true;
                    snackbar.classList.remove('opacity-0', 'translate-y-5');
                    snackbar.classList.add('opacity-100', 'translate-y-0');
                }
            }

            function hideSnackbar() {
                snackbar.classList.remove('opacity-100', 'translate-y-0');
                snackbar.classList.add('opacity-0', 'translate-y-5');
            }

            document.querySelectorAll('.entry-value-radio').forEach(radio => {
                radio.addEventListener('change', function() {
                    showSnackbar();
                });
            });

            snackbarButton.addEventListener('click', function() {
                submitButton.scrollIntoView({
                    behavior: 'smooth'
                });
            });

            function checkSnackbarVisibility() {
                const rect = submitButton.getBoundingClientRect();
                const isVisible = rect.top < window.innerHeight && rect.bottom >= 0;

                if (isVisible) {
                    hideSnackbar();
                } else {
                    if (isChanged) {
                        showSnackbar();
                    }
                }
            }

            document.addEventListener('scroll', checkSnackbarVisibility);
            window.addEventListener('resize', checkSnackbarVisibility);

            checkSnackbarVisibility();

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
                const button = document.getElementById('submit-button');
                const text = document.getElementById('submit-text');
                const spinner = document.getElementById('submit-spinner');

                button.disabled = true;
                text.textContent = "Menyimpan...";
                spinner.classList.remove("hidden");
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
                        snackbar.classList.add('hidden');
                        snackbar.classList.add('hidden');
                        button.disabled = false;
                        text.textContent = "Simpan";
                        spinner.classList.add("hidden");
                    })
                    .catch(error => {
                        console.error('Error saving entry values:', error);
                        alert('Terjadi kesalahan saat menyimpan data.');
                    });
            });

            function fetchTableData(periodId) {
                const categoryId = {{ $checklist_category->id }};
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
