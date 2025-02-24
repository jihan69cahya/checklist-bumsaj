@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <h1 class="mb-4 text-2xl font-bold">Beranda</h1>

    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="flex flex-col items-end p-4 text-white bg-yellow-500 rounded-lg">
            <div class="flex items-end gap-4">
                <span class="text-2xl font-bold" id="completed-checklists"></span>
                <i class="text-4xl fa-regular fa-circle-check"></i>
            </div>
            <p class="m-2 text-lg">Checklist sudah diisi</p>
        </div>
        <div class="flex flex-col items-end p-4 text-white bg-yellow-500 rounded-lg">
            <div class="flex items-end gap-4">
                <span class="text-2xl font-bold" id="uncompleted-checklists"></span>
                <i class="text-4xl fa-regular fa-circle"></i>
            </div>
            <p class="m-2 text-lg">Checklist belum diisi</p>
        </div>
        <div class="flex flex-col items-end p-4 text-white bg-yellow-500 rounded-lg">
            <div class="flex items-end gap-4">
                <span class="text-2xl font-bold" id="time-left"></span>
                <i class="text-4xl fa-regular fa-hourglass"></i>
            </div>
            <p class="m-2 text-lg">Menuju periode berikutnya</p>
        </div>
    </div>

    <p class="mb-2 font-bold">Kamis, 13 Februari 2025</p>

    <div class="flex flex-col w-full gap-4" id="progress-container">

    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const periods = @json($periods);

            function timeToMinutes(time) {
                const [hours, minutes, seconds] = time.split(':')
                return parseInt(hours) * 60 + parseInt(minutes)
            }

            function getCurrentTimeInMinutes() {
                const now = new Date()
                return now.getHours() * 60 + now.getMinutes()
            }

            function getCurrentPeriod(periods) {
                const currentTime = getCurrentTimeInMinutes()
                for (let period of periods) {
                    const startTime = timeToMinutes(period.start_time)
                    const endTime = timeToMinutes(period.end_time)

                    if (currentTime >= startTime && currentTime < endTime) {
                        return period
                    }
                }
                return null
            }

            function getTimeLeftUntilNextPeriod(periods, currentPeriod) {
                const currentTime = getCurrentTimeInMinutes();

                const currentPeriodIndex = periods.findIndex(p => p.id === currentPeriod.id);
                const nextPeriod = periods[currentPeriodIndex + 1];

                if (nextPeriod) {
                    const nextStartTime = timeToMinutes(nextPeriod.start_time);
                    return nextStartTime - currentTime;
                }
                return null;
            }

            const currentPeriod = getCurrentPeriod(periods)

            if (currentPeriod) {
                const timeLeft = getTimeLeftUntilNextPeriod(periods, currentPeriod)
                if (timeLeft >= 60) {
                    document.getElementById('time-left').innerText =
                        `${Math.floor(timeLeft / 60)} jam ${timeLeft % 60} menit`
                } else {
                    document.getElementById('time-left').innerText = `${timeLeft} menit`
                }
            }

            console.log('Current period id:', currentPeriod.id);

            const itemsCountByCategory = @json($items_count_by_category);
            const entriesCountByCategory = @json($entries_count_by_category);
            let completedChecklist = 0
            let unCompletedChecklist = itemsCountByCategory.length

            console.log(itemsCountByCategory);
            console.log(entriesCountByCategory);

            for (const [idx, category] of itemsCountByCategory.entries()) {
                if (category.checklist_items_count == entriesCountByCategory[idx].checklist_entries_count) {
                    completedChecklist++;
                    unCompletedChecklist--;
                }
            }

            document.getElementById('completed-checklists').innerText = `${completedChecklist}`
            document.getElementById('uncompleted-checklists').innerText = `${unCompletedChecklist}`

            const container = document.getElementById('progress-container')

            itemsCountByCategory.forEach((item, idx) => {
                const card = document.createElement('div');
                card.classList.add('w-full', 'flex', 'justify-between', 'border-[1px]', 'border-gray-500',
                    'px-4', 'py-2', 'rounded-md');

                const percentage = item.checklist_items_count > 0 ?
                    (Math.floor((entriesCountByCategory[idx].checklist_entries_count / item
                        .checklist_items_count) * 100)) :
                    0;

                card.innerHTML = `
                    <span>${item.name}</span>
                    <span>${entriesCountByCategory[idx].checklist_entries_count === 0 ? '0%' : `${percentage}%`}</span>
                `;

                container.appendChild(card);
            });

        })
    </script>
@endsection
