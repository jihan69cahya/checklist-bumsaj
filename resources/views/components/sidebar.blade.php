<div class="w-64 px-6 py-12 bg-[#1975c5] h-full text-white">
    <div class="flex justify-center">
        <img class="w-16 h-auto" src="{{ asset('images/logo_kementrian.png') }}" alt="Kementrian Logo">
    </div>
    <ul class="flex flex-col h-full gap-6 p-8 font-medium select-none pe-0 text-md">
        <li class="flex items-center gap-4 cursor-pointer">
            <div class="flex items-center justify-center w-6 h-6">
                <span class="fa-solid fa-home"></span>
            </div>
            <div class="w-full">
                <a href="{{ route('beranda') }}">Beranda</a>
            </div>
        </li>
        <li class="flex flex-col gap-4">
            <div class="flex items-center gap-4 cursor-pointer" id="checklist-label">
                <div class="flex items-center justify-center w-6 h-6">
                    <span class="fa-regular fa-circle-check"></span>
                </div>
                <div class="flex items-center justify-between w-full">
                    <span>Checklist</span>
                    <span class="fa-solid fa-caret-down"></span>
                </div>
            </div>
            <ul class="hidden w-full font-light" id="checklist-dropdown">
                <li>
                    <a class="block px-4 py-2 text-md" href="{{ route('checklist.fasilitas') }}">Fasilitas Gedung
                        Terminal</a>
                </li>
                <li>
                    <a class="block px-4 py-2 text-md" href="{{ route('checklist.kebersihan') }}">Kebersihan Gedung
                        Terminal</a>
                </li>
                <li>
                    <a class="block px-4 py-2 text-md" href="{{ route('checklist.curbside') }}">Kondisi Area
                        Curbside</a>
                </li>
            </ul>
        </li>
        <li class="flex items-center gap-4 cursor-pointer">
            <div class="flex items-center justify-center w-6 h-6">
                <span class="fa-solid fa-clipboard"></span>
            </div>
            <div class="w-full">
                <span>Rekapitulasi</span>
            </div>
        </li>
        <li class="flex items-center gap-4 mt-auto mb-8">
            <div class="flex items-center justify-center w-6 h-6">
                <span class="fa-solid fa-right-from-bracket"></span>
            </div>
            <div class="w-full">
                <span>Keluar</span>
            </div>
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
