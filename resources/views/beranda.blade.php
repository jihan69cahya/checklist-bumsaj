@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <h1 class="mb-4 text-2xl font-bold">Beranda</h1>

    <div id="infoCard" class="grid grid-cols-3 gap-4 mb-6">
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
            <p class="m-2 text-lg" id="period-desc">Menuju periode berikutnya</p>
        </div>
    </div>

    <p class="mb-2 font-bold">Kamis, 13 Februari 2025</p>
    <p id="periodeMessage" class="hidden text-8xl">Periode Berakhir</p>

    <div class="flex flex-col w-full gap-4" id="progress-container">

    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const periods = @json($periods);
            const itemsCountByCategory = @json($items_count_by_category);
            const entriesCountByCategory = @json($entries_count_by_category);
            const itemsCountBySubCategory = @json($items_count_by_subcategory);
            const entriesCountBySubCategory = @json($entries_count_by_subcategory);
            const entriesCountByCategoryToday = @json($entries_count_by_category_today);
            const entriesCountByPeriod = @json($entries_count_by_period);
            const ItemsCountByPeriod = @json($items_count_by_period);
            const totalItemsCount = @json($total_items_count);
            
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
                periodRecap(entriesCountByCategory)
                const timeLeft = getTimeLeftUntilNextPeriod(periods, currentPeriod)
                if (timeLeft >= 60) {
                    document.getElementById('time-left').innerText =
                        `${Math.floor(timeLeft / 60)} jam ${timeLeft % 60} menit`
                } else {
                    document.getElementById('time-left').innerText = `${timeLeft} menit`
                }
            } else {
                document.getElementById('period-desc').innerText = 'Periode Berakhir'
                //document.getElementById("periodeMessage").classList.remove("hidden")
                //document.getElementById("infoCard").classList.add("hidden");
                dayRecap(ItemsCountByPeriod,entriesCountByCategoryToday, totalItemsCount)
            }

            //console.log('Current period id:', currentPeriod.id)

            
            let completedChecklist = 0
            let unCompletedChecklist = itemsCountByCategory.length

            //console.log(itemsCountByCategory);
            //console.log(entriesCountByCategory);

            for (const [idx, category] of itemsCountByCategory.entries()) {
                if (category.checklist_items_count == entriesCountByCategory[idx].checklist_entries_count) {
                    completedChecklist++;
                    unCompletedChecklist--;
                }
            }

            document.getElementById('completed-checklists').innerText = `${completedChecklist}`
            document.getElementById('uncompleted-checklists').innerText = `${unCompletedChecklist}`

            
            function periodRecap(entriesCountByCategory){
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
            }
            
            console.log("Items Count By SubCategory:", itemsCountBySubCategory);
            function dayRecap(itemsCountByPeriod, entriesCountByCategoryToday, totalItemsCount) {
                console.log("Entries:", entriesCountByCategoryToday);
                console.log("Items:", itemsCountByPeriod);
                console.log("Total Items Count:", totalItemsCount);

                const container = document.getElementById('progress-container');
                container.innerHTML = '';

                const periodProgress = {};

                // Process checklist entries count per period
                entriesCountByCategoryToday.forEach(entry => {
                    const period = entry.period_id;
                    if (period === null) return; // Ignore null periods

                    if (!periodProgress[period]) {
                        periodProgress[period] = { totalEntries: 0 };
                    }

                    console.log(`Period ${period}: Adding ${entry.checklist_entries_count} entries`);
                    periodProgress[period].totalEntries += Number(entry.checklist_entries_count) || 0;
                });

                // Render progress per period
                Object.keys(periodProgress).forEach(period => {
                    const { totalEntries } = periodProgress[period];
                    const percentage = totalItemsCount > 0 ? Math.floor((totalEntries / totalItemsCount) * 100) : 0;

                    console.log(`Period ${period}: Total Entries = ${totalEntries}, Percentage = ${percentage}%`);

                    const card = document.createElement('div');
                    card.classList.add('w-full', 'flex', 'justify-between', 'border-[1px]', 'border-gray-500',
                        'px-4', 'py-2', 'rounded-md');

                    card.innerHTML = `
                        <span>Period ${period}</span>
                        <span>${percentage}%</span>
                    `;

                    container.appendChild(card);
                });
            }





        })
    </script>
@endsection
