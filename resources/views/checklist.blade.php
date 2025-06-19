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
                                    value="{{ $entry_value->id }}">
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

    <button
        class="relative z-50 flex items-center justify-center w-full gap-2 px-4 py-2 mt-4 text-white transition duration-300 bg-blue-600 rounded-md shadow-md hover:bg-yellow-500 disabled:bg-gray-400 disabled:cursor-not-allowed"
        id="submit-button">
        <span id="submit-text">Simpan</span>
        <span class="hidden w-5 h-5 border-2 border-white rounded-full border-t-transparent animate-spin"
            id="submit-spinner"></span>
    </button>

    <div id="zoomModal"
        class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50 opacity-0 pointer-events-none transition-opacity duration-300">
        <div id="zoomModalContent" class="relative transform scale-95 transition-all duration-300">
            <button id="closeModalBtn" class="absolute top-0 right-0 m-2 text-white text-2xl font-bold">&times;</button>
            <img id="zoomedImage" src="" class="max-h-screen max-w-full rounded-lg shadow-lg" />
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

            const radios = document.querySelectorAll('.entry-value-radio');

            radios.forEach(radio => {
                radio.addEventListener('change', function() {
                    const itemId = this.dataset.itemId;
                    const documentValue = this.dataset.document;

                    const uploadForm = document.querySelector(`#upload-form-${itemId}`);
                    const photoInput = document.querySelector(`#photo_${itemId}`);

                    if (uploadForm) {
                        uploadForm.classList.add('hidden');
                    }

                    if (documentValue === "1") {
                        uploadForm?.classList.remove('hidden');
                    } else {
                        if (photoInput) {
                            photoInput.value = '';
                        }
                    }
                });
            });

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
                    Swal.fire({
                        icon: 'warning',
                        title: 'Periode belum dipilih.',
                        confirmButtonText: 'OK'
                    });
                    button.disabled = false;
                    text.textContent = "Simpan";
                    spinner.classList.add("hidden");
                    return;
                }

                const now = new Date();
                const entryDate = now.toISOString().split('T')[0];
                const entryTime = now.toTimeString().split(' ')[0];

                const entries = [];
                const itemIds = new Set();

                document.querySelectorAll('.entry-value-radio').forEach(radio => {
                    itemIds.add(radio.getAttribute('data-item-id'));
                });

                let allFilled = true;
                const formData = new FormData();

                let isFileTooLarge = false;
                let oversizedFiles = [];

                itemIds.forEach(itemId => {
                    const selected = document.querySelector(
                        `.entry-value-radio[name="entry_value_${itemId}"]:checked`);
                    if (!selected) {
                        allFilled = false;
                    } else {
                        entries.push({
                            item_id: itemId,
                            entry_value_id: selected.getAttribute('data-entry-value-id'),
                            period_id: periodId,
                            entry_date: entryDate,
                            entry_time: entryTime,
                        });

                        const fileInput = document.querySelector(`#photo_${itemId}`);
                        if (fileInput && fileInput.files.length > 0) {
                            const file = fileInput.files[0];
                            if (file.size > 2 * 1024 * 1024) {
                                isFileTooLarge = true;
                                const label = fileInput.getAttribute('data-label') ||
                                    `Item ID: ${itemId}`;
                                oversizedFiles.push(label);
                            } else {
                                formData.append(`photo_${itemId}`, file);
                            }
                        }
                    }
                });

                if (!allFilled) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Semua item harus dichecklist sebelum menyimpan.',
                        confirmButtonText: 'OK'
                    });
                    button.disabled = false;
                    text.textContent = "Simpan";
                    spinner.classList.add("hidden");
                    return;
                }

                if (isFileTooLarge) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Ukuran file terlalu besar',
                        html: 'Berikut file yang melebihi 2MB:<br><ul>' +
                            oversizedFiles.map(label => `<li>- ${label}</li>`).join('') +
                            '</ul>',
                        confirmButtonText: 'OK'
                    });
                    button.disabled = false;
                    text.textContent = "Simpan";
                    spinner.classList.add("hidden");
                    return;
                }

                entries.forEach((entry, index) => {
                    formData.append(`entries[${index}][item_id]`, entry.item_id);
                    formData.append(`entries[${index}][entry_value_id]`, entry.entry_value_id);
                    formData.append(`entries[${index}][period_id]`, entry.period_id);
                    formData.append(`entries[${index}][entry_date]`, entry.entry_date);
                    formData.append(`entries[${index}][entry_time]`, entry.entry_time);
                });

                axios.post('/checklist/save-entry-values', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(response => {
                        hideSnackbar();
                        button.disabled = false;
                        text.textContent = "Simpan";
                        spinner.classList.add("hidden");
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil menyimpan data.',
                            confirmButtonText: 'OK'
                        });
                        location.reload();
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Terjadi kesalahan saat menyimpan data.',
                            confirmButtonText: 'OK'
                        });
                        button.disabled = false;
                        text.textContent = "Simpan";
                        spinner.classList.add("hidden");
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
        });
    </script>
@endsection
