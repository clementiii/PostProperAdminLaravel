$(document).ready(function () {
    $(".view-btn").on("click", function () {
        let requestId = $(this).data("id");

        $.ajax({
            url: `/document-request/${requestId}`,
            type: "GET",
            success: function (data) {
                // Populate modal fields with correct field names
                $("#modalTxnId").text(
                    data.Id ? `TXN-${data.Id}` : "TXN-undefined"
                );
                $("#modalDocumentType").text(data.DocumentType || "N/A");
                
                // Get quantity from the model (default to 1 if not available)
                const quantity = data.Quantity || 1;
                
                // Set price based on document type and multiply by quantity
                if (data.DocumentType && data.DocumentType.toLowerCase() === "cedula") {
                    $("#modalPrice").text("Depends on the income");
                } else {
                    // Calculate total price (₱50 × quantity)
                    const totalPrice = 50 * quantity;
                    $("#modalPrice").text(`₱${totalPrice.toFixed(2)}`);
                }
                
                $("#modalDate").text(data.DateRequested || "N/A");
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
