import { showNotification } from "../components/modal.js";
document
    .getElementById("productForm")
    .addEventListener("submit", async function (e) {
        e.preventDefault();
        let isValid = true;

        document
            .querySelectorAll(".error-message")
            .forEach((el) => (el.style.display = "none"));

        const validations = [
            {
                field: "name",
                errorId: "name-error",
                message: "Please enter product name",
            },
            {
                field: "description",
                errorId: "description-error",
                message: "Please enter product description",
            },
            {
                field: "petType",
                errorId: "petType-error",
                message: "Please select pet type",
            },
            {
                field: "category",
                errorId: "category-error",
                message: "Please select category",
            },
            {
                field: "price",
                errorId: "price-error",
                message: "Please enter a valid price",
            },
            {
                field: "wilaya",
                errorId: "wilaya-error",
                message: "Please select wilaya",
            },
        ];

        validations.forEach((validation) => {
            const field = document.getElementById(validation.field);
            const errorElement = document.getElementById(validation.errorId);

            if (!field.value.trim()) {
                errorElement.textContent = validation.message;
                errorElement.style.display = "block";
                field.style.borderColor = "#e63946";
                isValid = false;
            } else {
                field.style.borderColor = "#dee2e6";
            }
        });

        const priceField = document.getElementById("price");
        if (
            priceField.value &&
            (isNaN(priceField.value) || parseFloat(priceField.value) <= 0)
        ) {
            document.getElementById("price-error").textContent =
                "Price must be greater than 0";
            document.getElementById("price-error").style.display = "block";
            priceField.style.borderColor = "#e63946";
            isValid = false;
        }

        if (isValid) {
            const formData = new FormData(this);

            try {
                const response = await fetch("/api/products", {
                    method: "POST",
                    headers: {
                        Accept: "application/json",
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                    },
                    body: formData,
                });

                if (response.ok) {
                    await showNotification(
                        "Success!",
                        "Product submitted! It will appear once approved.",
                    );
                    window.location.href = "/market";
                } else {
                    const errorData = await response.json();
                    showNotification(
                        "Error",
                        errorData.message || "Failed to save product.",
                        "error",
                    );
                }
            } catch (error) {
                showNotification("Error", "Network error occurred.", "error");
            }
        }
    });

document.querySelectorAll("input, select, textarea").forEach((input) => {
    input.addEventListener("input", function () {
        if (this.value.trim()) {
            this.style.borderColor = "#dee2e6";
            const errorId = this.id + "-error";
            const errorElement = document.getElementById(errorId);
            if (errorElement) errorElement.style.display = "none";
        }
    });
});
