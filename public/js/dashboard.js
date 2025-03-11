$(document).ready(function () {
    $(".view-btn").on("click", function () {
        let requestId = $(this).data("id");

        $.ajax({
            url: `/document-request/${requestId}`,
            type: "GET",
            success: function (data) {
                // Populate modal fields with correct field names
                $("#modalTxnId").text(
                    data.id ? `TXN-${data.id}` : "TXN-undefined"
                );
                $("#modalDocumentType").text(data.DocumentType || "N/A");
                $("#modalPrice").text("N/A"); // Since price isn't in the model
                $("#modalDate").text(data.created_at || "N/A");
                $("#modalName").text(data.Name || "N/A");
                $("#modalGender").text(data.Gender || "N/A");
                $("#modalCivilStatus").text(data.CivilStatus || "N/A");
                $("#modalAddress").text(data.Address || "N/A");
                $("#modalTin").text(data.TIN_No || "N/A");
                $("#modalCtc").text(data.CTC_No || "N/A");
                

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
