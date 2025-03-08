$(document).ready(function () {
    $(".view-btn").on("click", function () {
        let requestId = $(this).data("id");

        $.ajax({
            url: `/document-request/${requestId}`,
            type: "GET",
            success: function (data) {
                // Populate modal fields
                $("#modalTxnId").text(`TXN-${data.id}`);
                $("#modalDocumentType").text(data.DocumentType);
                $("#modalPrice").text(data.price ?? "N/A");
                $("#modalDate").text(data.DateRequested);
                $("#modalName").text(data.Name);
                $("#modalGender").text(data.Gender ?? "N/A");
                $("#modalCivilStatus").text(data.CivilStatus ?? "N/A");
                $("#modalAddress").text(data.Address);
                $("#modalTin").text(data.TIN ?? "N/A");
                $("#modalCtc").text(data.CTCNumber ?? "N/A");

                // Show modal
                $("#modal").removeClass("hidden");
            },
            error: function () {
                alert("Error fetching document request details.");
            },
        });
    });

    // Close modal function
    function closeModal() {
        $("#modal").addClass("hidden");
    }

    window.closeModal = closeModal;
});

document.addEventListener("DOMContentLoaded", function () {
    function fetchDashboardData() {
        fetch("/dashboard/fetch-data")
            .then((response) => response.json())
            .then((data) => {
                document.getElementById("residentsCount").textContent =
                    data.registeredResidents;
                document.getElementById("pendingDocsCount").textContent =
                    data.pendingDocuments;
                document.getElementById("incidentCount").textContent =
                    data.incidentReports;
            })
            .catch((error) => console.error("Error fetching data:", error));
    }

    // Fetch data every 10 seconds
    setInterval(fetchDashboardData, 10000);
});
