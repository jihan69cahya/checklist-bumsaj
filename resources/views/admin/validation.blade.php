@extends('layouts.app')

@section('title', 'Validasi Checklist')

@section('content')
    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
        <h1 class="text-xl font-semibold text-gray-800">Validasi Checklist</h1>
        <p class="text-gray-600 text-sm leading-relaxed">
            Berikut merupakan data checklist yang perlu divalidasi. Harap tinjau dan pastikan kebenarannya.
        </p>
    </div>

    <table class="w-full mt-6 border border-collapse">
        <thead>
            <tr class="bg-gray-200">
                <th class="px-4 py-2 border">Nama User</th>
                <th class="px-4 py-2 border">Tanggal</th>
                <th class="px-4 py-2 border">Total Periode</th>
                <th class="px-4 py-2 border">Status Validasi</th>
                <th class="px-4 py-2 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $item)
                <tr class="text-center">
                    <td class="px-4 py-2 border">{{ $item['user_name'] }}</td>
                    <td class="px-4 py-2 border">{{ $item['tanggal'] }}</td>
                    <td class="px-4 py-2 border">{{ $item['total_periode'] }}</td>
                    <td class="px-4 py-2 border">
                        @if ($item['is_validate'])
                            <span
                                class="inline-block bg-green-100 text-green-700 text-sm font-medium px-3 py-1 rounded-full">
                                ✅ Sudah divalidasi
                            </span>
                        @else
                            <span class="inline-block bg-red-100 text-red-700 text-sm font-medium px-3 py-1 rounded-full">
                                ❌ Belum divalidasi
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-2 border text-center">
                        <div class="inline-flex space-x-2">
                            @if ($item['is_validate'] == 0)
                                @php
                                    $isToday = \Carbon\Carbon::parse($item['tanggal'])->isToday();
                                @endphp

                                @if ($isToday)
                                    @if ($item['total_periode'] == $periode)
                                        <button
                                            class="flex items-center gap-2 px-4 py-2 text-white transition duration-300 bg-blue-600 shadow-md hover:bg-yellow-600"
                                            id="validate-button"
                                            onclick="validation('{{ $item['tanggal'] }}', {{ $category_id }}, '{{ $category_identifier }}')">
                                            <i class="fas fa-check-circle"></i> Validasi
                                        </button>
                                    @else
                                        <button type="button"
                                            class="text-sm text-gray-600 italic px-3 py-1 border border-gray-300 rounded-md hover:bg-gray-100 transition"
                                            disabled>
                                            Periode belum lengkap, tidak dapat validasi
                                        </button>
                                    @endif
                                @else
                                    <button
                                        class="flex items-center gap-2 px-4 py-2 text-white transition duration-300 bg-blue-600 shadow-md hover:bg-yellow-600"
                                        id="validate-button"
                                        onclick="validation('{{ $item['tanggal'] }}', {{ $category_id }}, '{{ $category_identifier }}')">
                                        <i class="fas fa-check-circle"></i> Validasi
                                    </button>
                                @endif
                            @else
                                <button
                                    class="flex items-center gap-2 px-4 py-2 text-dark bg-yellow-500 shadow-inner cursor-not-allowed opacity-80"
                                    disabled>
                                    <i class="fas fa-lock"></i> Terkunci
                                </button>
                            @endif
                            <a href="{{ route('validation.detail', ['tanggal' => $item['tanggal'], 'category_id' => $category_id, 'category' => $category_identifier]) }}"
                                class="flex items-center gap-2 px-4 py-2 text-white transition duration-300 bg-gray-800 shadow-md hover:bg-gray-900"
                                id="detail-button">
                                <i class="fas fa-eye"></i> Detail
                            </a>

                        </div>
                    </td>
                </tr>
            @empty
                <tr class="text-center">
                    <td class="px-4 py-2 border" colspan="5">Tidak ada data checklist yang perlu divalidasi</td>
                </tr>
            @endforelse

        </tbody>
    </table>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function validation(tanggal, category_id, category) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: `Anda akan memvalidasi data untuk tanggal ${tanggal} dan kategori ${category}.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, validasi!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memvalidasi...',
                        text: 'Silakan tunggu',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    fetch('/validation/store', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            body: JSON.stringify({
                                tanggal: tanggal,
                                category_id: category_id
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            Swal.close();
                            if (data.success) {
                                Swal.fire(
                                    'Tervalidasi!',
                                    data.message,
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Gagal!',
                                    data.message,
                                    'error'
                                );
                            }
                            location.reload();
                        })
                        .catch(error => {
                            Swal.close();
                            Swal.fire(
                                'Terjadi Kesalahan!',
                                'Silakan coba lagi nanti.',
                                'error'
                            );
                            console.error(error);
                        });
                }
            });
        }
    </script>
@endsection
