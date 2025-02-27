@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <h1 class="mb-4 text-2xl font-bold">Beranda</h1>

    <div class="grid grid-cols-3 gap-4 mb-6" id="infoCard">
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
    <p class="hidden text-8xl" id="periodeMessage">Periode Berakhir</p>

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
            const groupedResults = @json($grouped_results);
            console.log('Grouped results: ', groupedResults);
            console.log('Items count: ', itemsCountByCategory);

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
            } else {
                document.getElementById('period-desc').innerText = 'Periode Berakhir'
                dayRecap(itemsCountByCategory, groupedResults)
            }

            let completedChecklist = 0
            let unCompletedChecklist = itemsCountByCategory.length

            for (const [idx, category] of itemsCountByCategory.entries()) {
                if (category.checklist_items_count == entriesCountByCategory[idx].checklist_entries_count) {
                    completedChecklist++;
                    unCompletedChecklist--;
                }
            }

            document.getElementById('completed-checklists').innerText = `${completedChecklist}`
            document.getElementById('uncompleted-checklists').innerText = `${unCompletedChecklist}`

            const container = document.getElementById('progress-container')

            function dayRecap(itemsCountByCategory, groupedResults) {
                const container = document.getElementById('progress-container');
                container.classList.add('w-full');
                container.innerHTML = '';

                for (let result in groupedResults) {
                    const periodContainer = document.createElement('div');
                    periodContainer.classList.add('w-full', 'flex', 'flex-col', 'gap-2');

                    const periodLabelContainer = document.createElement('div');
                    periodLabelContainer.classList.add('w-full', 'cursor-pointer', 'border-[1px]',
                        'border-gray-500', 'px-4', 'py-2', 'rounded-md', 'flex', 'justify-between',
                        'items-center');

                    const periodLabel = document.createElement('span');
                    periodLabel.innerText = groupedResults[result].period_label;
                    periodLabelContainer.appendChild(periodLabel);

                    let totalPercentage = 0;
                    let categoryCount = 0;

                    for (let category in groupedResults[result].categories) {
                        const correspondingItem = itemsCountByCategory.find(item => item.id == category);
                        const checklistItemsCount = correspondingItem ? correspondingItem.checklist_items_count : 0;

                        const percentage = checklistItemsCount > 0 ?
                            (Math.floor((groupedResults[result].categories[category].checklist_entries_count /
                                checklistItemsCount) * 100)) :
                            0;

                        totalPercentage += percentage;
                        categoryCount++;
                    }

                    const combinedPercentage = categoryCount > 0 ? Math.floor(totalPercentage / categoryCount) : 0;

                    // Create a container for combined percentage and caret icons
                    const caretContainer = document.createElement('span');
                    caretContainer.classList.add('flex', 'items-center', 'gap-2');

                    // Add combined percentage inside the caretContainer
                    const combinedPercentageSpan = document.createElement('span');
                    combinedPercentageSpan.innerText = `${combinedPercentage} %`;
                    caretContainer.appendChild(combinedPercentageSpan);

                    // Add caret icons to the right of the combined percentage
                    const caretDown = document.createElement('i');
                    caretDown.classList.add('fa-solid', 'fa-caret-down');
                    caretDown.classList.add('caret-icon'); // Class to toggle between up/down

                    const caretUp = document.createElement('i');
                    caretUp.classList.add('fa-solid', 'fa-caret-up', 'hidden'); // Initially hidden

                    caretContainer.appendChild(caretDown);
                    caretContainer.appendChild(caretUp);

                    // Append the caretContainer with percentage and caret icons to the label container
                    periodLabelContainer.appendChild(caretContainer);

                    const contentContainer = document.createElement('div');
                    contentContainer.classList.add('hidden', 'flex', 'flex-col', 'gap-2', 'px-4', 'py-2',
                        'bg-gray-100');

                    periodLabelContainer.addEventListener('click', function() {
                        contentContainer.classList.toggle('hidden');
                        // Toggle caret icon visibility
                        caretDown.classList.toggle('hidden');
                        caretUp.classList.toggle('hidden');
                    });

                    periodContainer.appendChild(periodLabelContainer);

                    for (let category in groupedResults[result].categories) {
                        const categoryCard = document.createElement('div');
                        categoryCard.classList.add('w-full', 'flex', 'justify-between', 'px-4', 'py-2',
                            'rounded-md');

                        const categoryName = document.createElement('span');
                        categoryName.innerText = groupedResults[result].categories[category].name;
                        categoryCard.appendChild(categoryName);

                        const correspondingItem = itemsCountByCategory.find(item => item.id == category);
                        const checklistItemsCount = correspondingItem ? correspondingItem.checklist_items_count : 0;

                        const percentage = checklistItemsCount > 0 ?
                            (Math.floor((groupedResults[result].categories[category].checklist_entries_count /
                                checklistItemsCount) * 100)) :
                            0;

                        const percentageSpan = document.createElement('span');
                        percentageSpan.innerText = `${percentage} %`;
                        categoryCard.appendChild(percentageSpan);

                        contentContainer.appendChild(categoryCard);
                    }

                    periodContainer.appendChild(contentContainer);
                    container.appendChild(periodContainer);
                }
            }

        })
    </script>
@endsection
