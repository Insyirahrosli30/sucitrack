document.addEventListener('DOMContentLoaded', () => {
    const monthYearText = document.getElementById('calendar-month-year');
    const daysGrid = document.getElementById('calendar-days-grid');
    const prevBtn = document.getElementById('prev-month-btn');
    const nextBtn = document.getElementById('next-month-btn');

    if (!daysGrid || !monthYearText) return;

    let currentDate = new Date();

    // Pull records safely passed via blade bridge array setup
    const records = window.menstrualRecords || [];

    function renderCalendar() {
        daysGrid.innerHTML = '';
        
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();

        // Title header calculation logic 
        const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        monthYearText.textContent = `${monthNames[month]} ${year}`;

        // Get bounds data structures
        const firstDayIndex = new Date(year, month, 1).getDay();
        const lastDay = new Date(year, month + 1, 0).getDate();
        const prevLastDay = new Date(year, month, 0).getDate();

        // 1. Fill previous month padding slots
        for (let x = firstDayIndex; x > 0; x--) {
            const dayDiv = document.createElement('div');
            dayDiv.classList.add('calendar-day-box', 'other-month', 'text-stone-300', 'text-xs');
            dayDiv.innerHTML = `<span>${prevLastDay - x + 1}</span>`;
            daysGrid.appendChild(dayDiv);
        }

        // 2. Fill current month days blocks
        for (let i = 1; i <= lastDay; i++) {
            const dayDiv = document.createElement('div');
            dayDiv.classList.add('calendar-day-box', 'text-stone-700', 'text-sm', 'font-medium', 'flex', 'flex-col', 'justify-between');
            
            // Layout styling structure
            dayDiv.innerHTML = `<span>${i}</span>`;

            // Check if this date intersects with any tracking records
            const cellDateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
            const cellDate = new Date(cellDateStr + "T00:00:00");

            let isPeriod = false;
            records.forEach(rec => {
                const startStr = rec.start ? rec.start.substring(0, 10) : '';
                const endStr = rec.end ? rec.end.substring(0, 10) : '';
                
                if (startStr) {
                    const startDate = new Date(startStr + "T00:00:00");
                    const endDate = endStr ? new Date(endStr + "T23:59:59") : new Date(); // assume ongoing is today

                    if (cellDate >= startDate && cellDate <= endDate) {
                        isPeriod = true;
                    }
                }
            });

            if (isPeriod) {
                dayDiv.classList.add('period-day');
            }

            daysGrid.appendChild(dayDiv);
        }

        // 3. Fill next month padding slots to complete full layout block alignment
        const totalCellsUsed = firstDayIndex + lastDay;
        const remainingSlots = 42 - totalCellsUsed; // Standard 6-row calendar grid metric
        for (let j = 1; j <= remainingSlots; j++) {
            const dayDiv = document.createElement('div');
            dayDiv.classList.add('calendar-day-box', 'other-month', 'text-stone-300', 'text-xs');
            dayDiv.innerHTML = `<span>${j}</span>`;
            daysGrid.appendChild(dayDiv);
        }
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();
        });
    }

    renderCalendar();
});