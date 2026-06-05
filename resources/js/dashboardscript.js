document.addEventListener("DOMContentLoaded", () => {
    const predictionHeader = document.getElementById("dash-prediction-header");
    const predictionDates = document.getElementById("dash-prediction-dates");
    const qadaContainer = document.getElementById("qada-list-container");

    const records = window.menstrualRecords || [];
    const prayerTimes = window.jakimPrayerTimes || {};

    function parseToJsDate(dateTimeStr) {
        if (!dateTimeStr) return null;
        return new Date(dateTimeStr.replace(" ", "T"));
    }

    function createPrayerTimeObject(dateStr, timeStr) {
        return new Date(`${dateStr}T${timeStr}`);
    }

    function runPredictionEngine() {
        if (!predictionHeader || !predictionDates) return;
        
        if (records.length === 0) {
            predictionHeader.textContent = "No Entries";
            predictionDates.textContent = "Log a boundary to build prediction window forecasts.";
            return;
        }

        let cycleLength = 28; 
        let bleedingDuration = 7;

        if (records.length >= 2) {
            let totalDays = 0;
            let sorted = [...records].sort((a, b) => parseToJsDate(a.start_datetime) - parseToJsDate(b.start_datetime));
            for (let i = 1; i < sorted.length; i++) {
                totalDays += Math.round((parseToJsDate(sorted[i].start_datetime) - parseToJsDate(sorted[i-1].start_datetime)) / (1000 * 60 * 60 * 24));
            }
            cycleLength = Math.round(totalDays / (sorted.length - 1)) || 28;
        }

        const latestRecord = [...records].sort((a, b) => parseToJsDate(b.start_datetime) - parseToJsDate(a.start_datetime))[0];
        const lastStart = parseToJsDate(latestRecord.start_datetime);
        
        const nextStart = new Date(lastStart);
        nextStart.setDate(nextStart.getDate() + cycleLength);

        const nextEnd = new Date(nextStart);
        nextEnd.setDate(nextStart.getDate() + bleedingDuration);

        const today = new Date().setHours(0,0,0,0);
        const diffDays = Math.round((nextStart - today) / (1000 * 60 * 60 * 24));

        if (diffDays > 0) {
            predictionHeader.textContent = `In ${diffDays} Days`;
        } else if (diffDays === 0) {
            predictionHeader.textContent = "Expected Today";
        } else {
            predictionHeader.textContent = "Ongoing / Overdue";
        }

        predictionDates.textContent = `Expected Window: ${nextStart.toLocaleDateString('en-US', {month:'short', day:'numeric'})} - ${nextEnd.toLocaleDateString('en-US', {month:'short', day:'numeric', year:'numeric'})}`;
    }

    function calculateQadaPrayers() {
        if (!qadaContainer) return;

        const validRecords = records.filter(r => r && r.start_datetime);

        if (validRecords.length === 0) {
            qadaContainer.innerHTML = `
                <div class="p-4 bg-stone-50 border border-stone-100 text-stone-600 rounded-xl text-xs flex items-center gap-3">
                    <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                    <div>
                        <strong class="font-semibold text-stone-800">Clear Standing Status</strong>
                        <p class="text-stone-400 mt-0.5">Calculations generate dynamically as timeline parameters populate.</p>
                    </div>
                </div>`;
            return;
        }

        let qadaObject = { Fajr: 0, Zuhr: 0, Asr: 0, Maghrib: 0, Isya: 0 };
        let hasQadaEntries = false;

        validRecords.forEach(record => {
            const startDateTime = parseToJsDate(record.start_datetime);
            const startDateStr = record.start_datetime.split(' ')[0];
            const endDateTime = parseToJsDate(record.end_datetime);
            const endDateStr = record.end_datetime ? record.end_datetime.split(' ')[0] : null;

            let bleedingHours = endDateTime ? (endDateTime - startDateTime) / (1000 * 60 * 60) : null;

            if (endDateTime && bleedingHours < 24) {
                Object.keys(prayerTimes).forEach(key => {
                    const checkTime = createPrayerTimeObject(startDateStr, prayerTimes[key]);
                    if (checkTime >= startDateTime && checkTime <= endDateTime) {
                        let cleanName = key.charAt(0).toUpperCase() + key.slice(1);
                        if (cleanName === "Zohor") cleanName = "Zuhr";
                        if (cleanName === "Isyak") cleanName = "Isya";
                        qadaObject[cleanName]++;
                        hasQadaEntries = true;
                    }
                });
                return; 
            }

            Object.keys(prayerTimes).forEach(key => {
                const prayerStartTime = createPrayerTimeObject(startDateStr, prayerTimes[key]);
                const executionThreshold = new Date(prayerStartTime.getTime() + 3000);

                if (startDateTime >= executionThreshold) {
                    let isNextPrayerStarted = false;
                    Object.keys(prayerTimes).forEach(nextKey => {
                        const nextPrayerTime = createPrayerTimeObject(startDateStr, prayerTimes[nextKey]);
                        if (nextPrayerTime > prayerStartTime && startDateTime >= nextPrayerTime) {
                            isNextPrayerStarted = true;
                        }
                    });

                    if (!isNextPrayerStarted) {
                        let cleanName = key.charAt(0).toUpperCase() + key.slice(1);
                        if (cleanName === "Zohor") cleanName = "Zuhr";
                        if (cleanName === "Isyak") cleanName = "Isya";
                        qadaObject[cleanName]++;
                        hasQadaEntries = true;
                    }
                }
            });

            if (endDateTime && bleedingHours >= 24) {
                const asarStartTime = createPrayerTimeObject(endDateStr, prayerTimes.asar);
                const asarThreshold = new Date(asarStartTime.getTime() + 3000);
                const isyakStartTime = createPrayerTimeObject(endDateStr, prayerTimes.isyak);
                const isyakThreshold = new Date(isyakStartTime.getTime() + 3000);

                if (endDateTime >= asarThreshold && endDateTime < createPrayerTimeObject(endDateStr, prayerTimes.maghrib)) {
                    qadaObject.Zuhr++;
                    hasQadaEntries = true;
                }
                if (endDateTime >= isyakThreshold) {
                    qadaObject.Maghrib++;
                    hasQadaEntries = true;
                }
            }
        });

        if (!hasQadaEntries) {
            qadaContainer.innerHTML = `
                <div class="p-4 bg-emerald-50/60 border border-emerald-100 text-emerald-800 rounded-xl text-xs flex items-center gap-3">
                    <span class="text-emerald-500 font-bold">✓</span>
                    <div>
                        <strong class="font-semibold">All Obligations Met</strong>
                        <p class="text-emerald-600/80 mt-0.5">No outstanding qada requirements calculated from current records.</p>
                    </div>
                </div>`;
            return;
        }

        let listHtml = `<div class="space-y-2">`;
        Object.keys(qadaObject).forEach(prayer => {
            if (qadaObject[prayer] > 0) {
                listHtml += `
                    <div class="flex justify-between items-center bg-stone-50 border border-stone-100 p-3 rounded-xl">
                        <span class="text-xs font-semibold text-stone-700">${prayer}</span>
                        <span class="px-2.5 py-1 bg-rose-50 text-rose-600 border border-rose-100 text-[11px] font-bold rounded-lg">
                            Owed Count: ${qadaObject[prayer]}
                        </span>
                    </div>`;
            }
        });
        listHtml += `</div>`;
        
        qadaContainer.innerHTML = listHtml;
    }

    runPredictionEngine();
    calculateQadaPrayers();
});