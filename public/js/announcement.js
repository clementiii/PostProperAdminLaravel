document.addEventListener("DOMContentLoaded", function () {
    const uploadContainer = document.getElementById("upload-container");
    const fileInput = document.querySelector(".file-input");
    const imagePreviewContainer = document.getElementById(
        "image-preview-container"
    );
    const errorContainer = document.getElementById("upload-error");
    const announcementForm = document.getElementById("announcement-form");

    uploadContainer.addEventListener("click", () => fileInput.click());

    fileInput.addEventListener("change", function (event) {
        const files = Array.from(event.target.files);

        errorContainer.classList.add("hidden");
        errorContainer.textContent = "";

        // Validate image count
        const currentImages =
            imagePreviewContainer.querySelectorAll(".image-preview").length;
        if (files.length + currentImages > 5) {
            showError(
                `You can upload a maximum of 5 images. Current: ${currentImages}`
            );
            fileInput.value = "";
            return;
        }

        // Validate image size and type
        files.forEach((file) => {
            if (!["image/jpeg", "image/png"].includes(file.type)) {
                showError(
                    `${file.name} is not a valid image type (JPG/PNG only).`
                );
                return;
            }
            if (file.size > 10 * 1024 * 1024) {
                showError(`${file.name} exceeds the maximum size of 10MB.`);
                return;
            }
            previewImage(file);
        });

        fileInput.value = "";
    });

    function showError(message) {
        errorContainer.textContent = message;
        errorContainer.classList.remove("hidden");
    }

    // Preview image
    function previewImage(file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            const preview = document.createElement("div");
            preview.className = "image-preview relative mr-2 mb-2";
            preview.innerHTML = `
                <img src="${e.target.result}" class="w-24 h-24 object-cover rounded">
                <button type="button" class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center" aria-label="Remove">
                    <span class="material-icons text-sm">close</span>
                </button>`;
            preview
                .querySelector("button")
                .addEventListener("click", () => preview.remove());
            imagePreviewContainer.appendChild(preview);
        };
        reader.readAsDataURL(file);
    }

    // Confirmation before delete
    announcementForm.addEventListener("submit", function (e) {
        if (!confirm("Are you sure you want to post this announcement?")) {
            e.preventDefault();
        }
    });

    const deleteButtons = document.querySelectorAll(".btn-delete");

    deleteButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const announcementId = this.getAttribute("data-id");

            if (
                window.confirm(
                    "Are you sure you want to delete this announcement? This action cannot be undone."
                )
            ) {
                fetch(`/announcements/${announcementId}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                    },
                })
                    .then((response) => {
                        if (response.ok) {
                            location.reload();
                        } else {
                            alert("Failed to delete the announcement.");
                        }
                    })
                    .catch(() =>
                        alert(
                            "An error occurred while deleting the announcement."
                        )
                    );
            }
        });
    });
});
