document.addEventListener("DOMContentLoaded", () => {
    const predictionHeader = document.getElementById("dash-prediction-header");
    const predictionDates = document.getElementById("dash-prediction-dates");
    
    // Membaca data yang di-inject dari blade global layer window
    const records = window.menstrualRecords || [];

    // NOTA: Segala jenis EventListener AJAX Fetch lamak yang menyebabkan kerosakan JSON telah 
    // dibuang sepenuhnya. Kita gunakan sepenuhnya penyerahan form native HTML di dalam Blade.

    function parseToJsDate(dateTimeStr) {
        if (!dateTimeStr) return null;
        return new Date(dateTimeStr.replace(" ", "T"));
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

    runPredictionEngine();
});