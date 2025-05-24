// jQuery part for modal - Remains unchanged
$(document).ready(function () {
    $(".view-btn").on("click", function () {
        let requestId = $(this).data("id");

        console.log("Fetching document details for ID:", requestId);

        $.ajax({
            url: `/document-request/${requestId}`,
            type: "GET",
            dataType: "json",
            success: function (data) {
                console.log("Response data:", data);

                // Populate modal fields
                $("#modalTxnId").text(
                    data.Id ? `TXN-${data.Id}` : "TXN-undefined"
                );
                $("#modalDocumentType").text(data.DocumentType || "N/A");

                const quantity = data.Quantity || 1;
                if (
                    data.DocumentType &&
                    data.DocumentType.toLowerCase() === "cedula"
                ) {
                    $("#modalPrice").text("Depends on the income");
                } else {
                    const totalPrice = 50 * quantity;
                    $("#modalPrice").text(`₱${totalPrice.toFixed(2)}`);
                }

                // Set the status with proper capitalization
                const status = data.Status
                    ? data.Status.charAt(0).toUpperCase() +
                      data.Status.slice(1).toLowerCase()
                    : "N/A";
                $("#modalStatus").text(status);

                // Update status class
                const statusColors = {
                    pending: "bg-yellow-100 text-yellow-800",
                    overdue: "bg-red-100 text-red-800",
                    rejected: "bg-gray-200 text-gray-700",
                    approved: "bg-green-100 text-green-800",
                    cancelled: "bg-gray-300 text-gray-600",
                };

                // Get lowercase status for comparison
                const statusLower = (data.Status || "").toLowerCase();

                // Remove all possible status classes before applying the new one
                $("#modalStatusContainer")
                    .removeClass()
                    .addClass(
                        `text-sm font-semibold px-3 py-1 rounded-full ${
                            statusColors[statusLower] ||
                            "bg-gray-100 text-gray-800"
                        }`
                    );

                // Add pickup status badge if document is approved
                if (statusLower === "approved") {
                    const pickupStatus = data.pickup_status || "pending";
                    const isPickedUp = pickupStatus === "picked_up";
                    const pickupText = isPickedUp
                        ? "Picked Up"
                        : "Awaiting Pickup";
                    const pickupClass = isPickedUp
                        ? "bg-purple-200 text-purple-800"
                        : "bg-blue-200 text-blue-800";

                    // Create or update pickup status badge
                    if ($("#modalPickupStatus").length) {
                        $("#modalPickupStatus")
                            .text(pickupText)
                            .removeClass()
                            .addClass(
                                `text-sm font-semibold px-3 py-1 rounded-full ${pickupClass}`
                            );
                    } else {
                        $("#modalStatusContainer").after(
                            `<span id="modalPickupStatus" class="text-sm font-semibold px-3 py-1 rounded-full ${pickupClass} ml-2">${pickupText}</span>`
                        );
                    }
                } else if ($("#modalPickupStatus").length) {
                    // Remove pickup status badge if document is not approved
                    $("#modalPickupStatus").remove();
                }

                // Format dates properly
                const formatDate = (dateString) => {
                    if (!dateString) return "N/A";

                    try {
                        // Parse the date (works with both ISO format and already formatted dates)
                        const date = new Date(dateString);

                        // Check if date is valid
                        if (isNaN(date.getTime())) return dateString;

                        // Format the date: Month Day, Year Hour:Minute AM/PM
                        const options = {
                            year: "numeric",
                            month: "long",
                            day: "numeric",
                            hour: "2-digit",
                            minute: "2-digit",
                        };

                        return date.toLocaleDateString("en-US", options);
                    } catch (e) {
                        console.error("Error formatting date:", e);
                        return dateString;
                    }
                };

                // Set formatted date
                $("#modalDate").text(formatDate(data.DateRequested));

                $("#modalName").text(data.Name || "N/A");
                $("#modalGender").text(data.Gender || "N/A");
                $("#modalCivilStatus").text(data.CivilStatus || "N/A");
                $("#modalAddress").text(data.Address || "N/A");
                $("#modalTin").text(data.TIN_No || "N/A");
                $("#modalCtc").text(data.CTC_No || "N/A");

                // Show modal
                $("#modal").removeClass("hidden");
            },
            error: function (xhr, status, error) {
                console.error("Error fetching document details:", error);
                console.error("Status:", status);
                console.error("Response:", xhr.responseText);

                try {
                    const errorData = JSON.parse(xhr.responseText);
                    alert(
                        errorData.error ||
                            "Error fetching document request details."
                    );
                } catch (e) {
                    alert(
                        "Error fetching document request details. Please try again later."
                    );
                }
            },
        });
    });

    // Close modal function
    function closeModal() {
        $("#modal").addClass("hidden");
    }

    // Close modal when clicking outside of it
    $(document).on("click", function (event) {
        const modal = $("#modal");
        const modalContent = $(".modal-content");
        if (
            modal.is(":visible") &&
            !$(event.target).closest(modalContent).length &&
            !$(event.target).is(".view-btn")
        ) {
            closeModal();
        }
    });

    // Close modal when clicking the "X" button
    $(".close-modal-btn").on("click", function () {
        closeModal();
    });

    window.closeModal = closeModal;
});

// Optimized dashboard data fetching with intelligent caching and reduced polling
document.addEventListener("DOMContentLoaded", function () {
    // Cache configuration - similar to Android app
    const CACHE_DURATION = 30000; // 30 seconds cache duration
    const POLLING_INTERVAL_FOREGROUND = 45000; // 45 seconds when tab is active
    const POLLING_INTERVAL_BACKGROUND = 120000; // 2 minutes when tab is inactive
    
    let lastCacheTime = 0;
    let cachedData = null;
    let pollingInterval = null;
    let isTabActive = true;
    
    // Track tab visibility
    document.addEventListener('visibilitychange', function() {
        isTabActive = !document.hidden;
        restartPolling();
    });
    
    // Check if data is cached and still valid
    function isCacheValid() {
        return cachedData && (Date.now() - lastCacheTime) < CACHE_DURATION;
    }
    
    function fetchDashboardData() {
        // Check cache first
        if (isCacheValid()) {
            console.log("Using cached dashboard data");
            updateDashboardElements(cachedData);
            return Promise.resolve(cachedData);
        }
        
        console.log("Fetching fresh dashboard data");
        return fetch("/dashboard/fetch-data")
            .then((response) => {
                // Check for server errors first
                if (!response.ok) {
                    // If server error, don't try to parse as JSON, just throw
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                // Only attempt to parse as JSON if response is OK
                return response.json();
            })
            .then((data) => {
                // Cache the data
                cachedData = data;
                lastCacheTime = Date.now();
                
                updateDashboardElements(data);
                return data;
            })
            .catch((error) => {
                // Log the actual error, including potential JSON parsing errors or HTTP errors
                console.error(
                    "Error fetching or processing dashboard data:",
                    error
                );
                // If we have cached data, use it as fallback
                if (cachedData) {
                    console.log("Using cached data as fallback");
                    updateDashboardElements(cachedData);
                }
            });
    }
    
    function updateDashboardElements(data) {
        // Only update elements if we're on the main dashboard page
        // Check for an element that should only exist on the dashboard page
        const isDashboardPage = document.querySelector('.dashboard-specific-content') !== null;
        
        if (!isDashboardPage) {
            console.log("Not on the main dashboard page, skipping stats updates.");
            return;
        }
        
        // Update dashboard elements
        const residentsCountEl = document.getElementById("residentsCount");
        if (residentsCountEl) {
            residentsCountEl.textContent = data.registeredResidents;
        }

        const pendingDocsCountEl = document.getElementById("pendingDocsCount");
        if (pendingDocsCountEl) {
            pendingDocsCountEl.textContent = data.pendingDocuments;
        }

        const incidentCountEl = document.getElementById("incidentCount");
        if (incidentCountEl) {
            incidentCountEl.textContent = data.incidentReports;
        }
    }
    
    function startPolling() {
        const interval = isTabActive ? POLLING_INTERVAL_FOREGROUND : POLLING_INTERVAL_BACKGROUND;
        console.log(`Starting dashboard polling with ${interval/1000}s interval (tab ${isTabActive ? 'active' : 'inactive'})`);
        
        pollingInterval = setInterval(fetchDashboardData, interval);
    }
    
    function stopPolling() {
        if (pollingInterval) {
            clearInterval(pollingInterval);
            pollingInterval = null;
        }
    }
    
    function restartPolling() {
        stopPolling();
        startPolling();
    }

    // Only start polling if we're on the dashboard page
    // Look for a more specific element that should only exist on the dashboard page
    const isDashboardPage = document.querySelector('.dashboard-specific-content') !== null;
    
    if (isDashboardPage) {
        fetchDashboardData(); // Initial fetch
        startPolling();
        console.log("Dashboard polling started with intelligent caching and reduced frequency.");
    } else {
        console.log(
            "Not on the main dashboard page, skipping dashboard data polling."
        );
    }
});
