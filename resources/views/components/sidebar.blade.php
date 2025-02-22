<div class="w-64 px-6 py-12 bg-[#1975c5] h-full text-white">
    <div class="flex justify-center">
        <img class="w-16 h-auto" src="{{ asset('images/logo_kementrian.png') }}" alt="Kementrian Logo">
    </div>
    <ul class="flex flex-col h-full gap-6 p-8 font-medium select-none pe-0 text-md">
        <a href="{{ route('beranda') }}" class="flex items-center gap-4 w-full">
            <div class="flex items-center justify-center w-6 h-6">
                <span class="fa-solid fa-home"></span>
            </div>
            <span>Beranda</span>
        </a>
        <li class="flex flex-col gap-4">
            <div class="flex items-center gap-4 cursor-pointer" id="checklist-label">
                <div class="flex items-center justify-center w-6 h-6">
                    <span class="fa-regular fa-circle-check"></span>
                </div>
                <span>Checklist</span>
            </div>
            <ul class="hidden w-full font-light" id="checklist-dropdown">
                @php
                    $categories = App\Models\ChecklistCategory::all();
                @endphp

                @foreach ($categories as $category)
                    <li>
                        <a class="block px-4 py-2 text-md" href="#">{{ $category->category_name }}</a>
                    </li>
                @endforeach
            </ul>
        </li>
        <li class="flex items-center gap-4 cursor-pointer">
            <a href="{{ route('rekapitulasi') }}" class="flex items-center gap-4 w-full">
                <div class="flex items-center justify-center w-6 h-6">
                    <span class="fa-solid fa-clipboard"></span>
                </div>
                <span>Rekapitulasi</span>
            </a>
        </li>

        <li class="flex items-center gap-4 mt-auto mb-8">
            <div class="flex items-center justify-center w-6 h-6">
                <span class="fa-solid fa-right-from-bracket"></span>
            </div>
            <span>Keluar</span>
        </li>
    </ul>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const checklistDiv = document.getElementById('checklist-label');

        if (checklistDiv) {
            checklistDiv.addEventListener('click', function() {
                const dropdown = document.getElementById('checklist-dropdown');
                dropdown.classList.toggle('hidden');
            });
        }
    });
</script>
