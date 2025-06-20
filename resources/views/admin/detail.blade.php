@extends('layouts.app')

@section('title', 'Detail Checklist')

@section('content')
    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
        <h1 class="text-xl font-semibold text-gray-800">Detail Checklist</h1>
        <p class="text-gray-600 text-sm leading-relaxed">
            Berikut merupakan data detail checklist {{ $category }} pada tanggal {{ $tanggal }}
        </p>

        <a href="{{ url()->previous() }}"
            class="inline-block mt-4 px-4 py-2 bg-gray-700 text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition">
            ← Kembali
        </a>
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
                <th class="px-4 py-2 border border-gray-300" rowspan="2">Dokumentasi</th>
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
                    <td class="px-4 py-2 font-semibold bg-gray-200" colspan="{{ 3 + count($entry_values) }}">
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
                                    data-entry-value-id="{{ $entry_value->id }}"
                                    data-document="{{ $entry_value->document }}" type="radio"
                                    value="{{ $entry_value->id }}" disabled>
                            </td>
                        @endforeach
                        <td class="px-4 py-2 border border-gray-300">
                            {{ $item->keterangan }}
                        </td>
                        <td class="px-4 py-2 border border-gray-300 text-center entry-value-photo"
                            data-doc-cell="{{ $item->id }}">
                            {{-- Tempat untuk dokumentasi --}}
                        </td>

                    </tr>
                    <tr id="upload-form-{{ $item->id }}" class="hidden">
                        <td colspan="{{ count($entry_values) + 2 }}" class="px-4 py-4 border border-gray-300 bg-blue-50">
                            <label for="photo_{{ $item->id }}" class="block mb-2 text-sm font-semibold text-blue-700">
                                Upload Dokumentasi <span class="text-xs text-gray-500">(max: 2MB)</span>
                            </label>
                            <div class="flex items-center gap-4">
                                <input type="file" name="photo_{{ $item->id }}" id="photo_{{ $item->id }}"
                                    data-label="{{ $item->name }}"
                                    class="block w-full text-sm text-blue-700 border border-blue-300 rounded-lg cursor-pointer bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400"
                                    accept="image/*">
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    <div id="zoomModal"
        class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50 opacity-0 pointer-events-none transition-opacity duration-300">
        <div id="zoomModalContent" class="relative transform scale-95 transition-all duration-300">
            <button id="closeModalBtn" class="absolute top-0 right-0 m-2 text-white text-2xl font-bold">&times;</button>
            <img id="zoomedImage" src="" class="max-h-screen max-w-full rounded-lg shadow-lg" />
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

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

                const dropdownButton = document.getElementById('period-dropdown-button');
                dropdownButton.innerHTML = `
                        ${periodText}
                        <span class="ml-2">▼</span>
                    `;
                dropdownButton.setAttribute('data-period-id', periodId);

                document.getElementById('period-dropdown-menu').classList.add('hidden');

                document.querySelectorAll('tr[id^="upload-form-"]').forEach(function(formRow) {
                    formRow.classList.add('hidden');
                });

                document.querySelectorAll('input[type="file"][id^="photo_"]').forEach(function(
                    fileInput) {
                    fileInput.value = '';
                });

                fetchTableData(periodId);
            });
        });

        function fetchTableData(periodId) {
            const categoryId = {{ $checklist_category->id }};
            const entryDate = '{{ $tanggal }}'
            const params = {
                checklist_category_id: categoryId,
                entry_date: entryDate,
                period_id: periodId
            };

            document.querySelectorAll('.entry-value-radio').forEach(radio => {
                radio.checked = false;
            });

            document.querySelectorAll('.entry-value-photo').forEach(cell => {
                cell.innerHTML = '';
            });

            axios.get('/checklist/entries-by-period', {
                    params
                })
                .then(response => {
                    const entries = response.data;

                    entries.forEach(entry => {
                        const itemId = entry.checklist_item_id;
                        const entryValueId = entry.entry_value_id;
                        const photoPath = entry.photo;
                        const validate = entry.is_validate;

                        const radioButtons = document.querySelectorAll(
                            `.entry-value-radio[data-item-id="${itemId}"]`
                        );

                        radioButtons.forEach(radio => {
                            if (parseInt(radio.dataset.entryValueId) === entryValueId) {
                                radio.checked = true;
                            }

                            if (validate == 1) {
                                radio.disabled = true;
                            }
                        });

                        const docCell = document.querySelector(`td[data-doc-cell="${itemId}"]`);

                        if (docCell) {
                            docCell.innerHTML = photoPath ?
                                `<img src="/storage/${photoPath}" alt="Dokumentasi" class="h-16 mx-auto rounded-md cursor-pointer zoomable" data-src="/storage/${photoPath}">` :
                                `<span class="text-gray-400 italic text-sm">No Documentation</span>`;
                        }

                    });

                })
                .catch(error => {
                    console.error('Error fetching entries:', error);
                });
        }

        const zoomModal = document.getElementById('zoomModal');
        const zoomedImage = document.getElementById('zoomedImage');
        const zoomModalContent = document.getElementById('zoomModalContent');

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('zoomable')) {
                const src = e.target.getAttribute('data-src');
                zoomedImage.src = src;

                zoomModal.classList.remove('pointer-events-none');
                zoomModal.classList.remove('opacity-0');
                zoomModalContent.classList.remove('scale-95');
                zoomModalContent.classList.add('scale-100');
            }
        });

        function closeZoomModal() {
            zoomModal.classList.add('opacity-0');
            zoomModalContent.classList.add('scale-95');
            zoomModalContent.classList.remove('scale-100');

            setTimeout(() => {
                zoomModal.classList.add('pointer-events-none');
                zoomedImage.src = '';
            }, 300);
        }

        document.getElementById('closeModalBtn').addEventListener('click', closeZoomModal);

        zoomModal.addEventListener('click', function(e) {
            if (e.target === zoomModal) {
                closeZoomModal();
            }
        });

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
    </script>
@endsection
