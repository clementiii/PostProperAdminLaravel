$(document).ready(function () {
    $(".view-btn").on("click", function () {
        let requestId = $(this).data("id");
    
        $.ajax({
            url: `/document-request/${requestId}`,
            type: "GET",
            success: function (data) {
                // Populate modal fields
                $("#modalTxnId").text(data.Id ? `TXN-${data.Id}` : "TXN-undefined");
                $("#modalDocumentType").text(data.DocumentType || "N/A");
    
                const quantity = data.Quantity || 1;
                if (data.DocumentType && data.DocumentType.toLowerCase() === "cedula") {
                    $("#modalPrice").text("Depends on the income");
                } else {
                    const totalPrice = 50 * quantity;
                    $("#modalPrice").text(`₱${totalPrice.toFixed(2)}`);
                }
                $("#modalStatus").text(data.Status || "N/A");
                $("#modalDate").text(data.DateRequested || "N/A");
                $("#modalName").text(data.Name || "N/A");
                $("#modalGender").text(data.Gender || "N/A");
                $("#modalCivilStatus").text(data.CivilStatus || "N/A");
                $("#modalAddress").text(data.Address || "N/A");
                $("#modalTin").text(data.TIN_No || "N/A");
                $("#modalCtc").text(data.CTC_No || "N/A");
    
                // Update status badge color dynamically
                const status = (data.Status || "").toLowerCase();
                const statusColors = {
                    pending: "bg-yellow-100 text-yellow-800",
                    overdue: "bg-red-100 text-red-800",
                    rejected: "bg-gray-200 text-gray-700",
                    approved: "bg-green-100 text-green-800",
                    cancelled: "bg-gray-300 text-gray-600",
                    complete: "bg-blue-100 text-blue-800",
                };
    
                // Remove all possible status classes before applying the new one
                $("#modalStatusContainer")
                    .removeClass()
                    .addClass(
                        `text-sm font-semibold px-3 py-1 rounded-full ${statusColors[status] || "bg-gray-100 text-gray-800"}`
                    );
    
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
