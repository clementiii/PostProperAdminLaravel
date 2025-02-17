document.addEventListener('DOMContentLoaded', function () {
    function fetchDashboardData() {
        fetch('/dashboard/fetch-data')
            .then(response => response.json())
            .then(data => {
                document.getElementById('residentsCount').textContent = data.registeredResidents;
                document.getElementById('pendingDocsCount').textContent = data.pendingDocuments;
                document.getElementById('incidentCount').textContent = data.incidentReports;
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    // Fetch data every 10 seconds
    setInterval(fetchDashboardData, 10000);
});
