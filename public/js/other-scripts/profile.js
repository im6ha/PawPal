import { Confirm } from "../components/modal.js";


document.addEventListener("DOMContentLoaded", function () {
    const avatarInput = document.getElementById("avatar-input");
    const editModal = document.getElementById("edit-modal");
    const modalField = document.getElementById("modal-field");
    const modalTitle = document.getElementById("modal-title");
    const pwModal = document.getElementById("password-modal");
    let activeFieldId = null;

    avatarInput.addEventListener("change", function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (event) {
                updateAvatarUI(event.target.result);
                showNotify("Preview updated. Save to confirm.", "info");
            };
            reader.readAsDataURL(file);
        }
    });

    document.querySelectorAll(".edit-btn").forEach(btn => {
        btn.addEventListener("click", () => {
            activeFieldId = btn.dataset.field;
            const inputElement = document.getElementById(activeFieldId);
            const label = btn.closest('.info-item').querySelector('label').textContent;
            
            modalTitle.textContent = `Edit ${label}`;
            modalField.value = inputElement.value;
            editModal.style.display = "flex";
        });
    });

    document.getElementById("modal-save").onclick = () => {
        if (activeFieldId) {
            const newValue = modalField.value.trim();
            if (newValue) {
                document.getElementById(activeFieldId).value = newValue;
                if(activeFieldId === "full-name") {
                    document.querySelector(".user-name").textContent = newValue;
                }
                closeEditModal();
            }
        }
    };

   document.getElementById("save-changes").onclick = async () => {
    const formData = new FormData();
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
    formData.append('name', document.getElementById('full-name').value);
    formData.append('email', document.getElementById('email').value);
        formData.append('phone', document.getElementById('phone').value);
        
        if (avatarInput.files[0]) {
            formData.append('profile_image', avatarInput.files[0]);
        }

        try {
            const response = await fetch('/profile-update', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            });

            const result = await response.json();
            if (result.success) {
                showNotify("Profile saved successfully", "success");
            } else {
                showNotify(result.message || "Error saving profile", "error");
            }
        } catch (error) {
            showNotify("Network error", "error");
        }
    };

    function closeEditModal() { editModal.style.display = "none"; }
    function closePwModal() { pwModal.style.display = "none"; }

    document.querySelectorAll(".close, #modal-cancel").forEach(el => el.onclick = closeEditModal);
    document.querySelector(".action-btn:not(.danger)").onclick = () => pwModal.style.display = "flex";
    document.querySelector(".close-pw").onclick = closePwModal;
    document.getElementById("pw-cancel").onclick = closePwModal;

    window.onclick = (e) => {
        if (e.target === editModal) closeEditModal();
        if (e.target === pwModal) closePwModal();
    };
});

function updateAvatarUI(src) {
    const container = document.getElementById("avatar-display");
    const img = container.querySelector('img') || document.createElement('img');
    img.src = src;
    img.style = "width:100%; height:100%; object-fit:cover; border-radius:50%;";
    if (!container.querySelector('img')) container.prepend(img);
    const initial = container.querySelector('.avatar-initial');
    if (initial) initial.remove();
}

function showNotify(message, type = "success") {
    let container = document.getElementById("notification-container") || Object.assign(document.createElement("div"), {id: "notification-container"});
    document.body.appendChild(container);
    const toast = Object.assign(document.createElement("div"), {className: `notification-toast ${type}`, innerHTML: `<span>${message}</span>`});
    container.appendChild(toast);
    setTimeout(() => toast.classList.add("show"), 10);
    setTimeout(() => { toast.classList.remove("show"); setTimeout(() => toast.remove(), 500); }, 3000);
}


document.getElementById("pw-save").onclick = async () => {
    const currentPw = document.getElementById('current-pw').value;
    const newPw = document.getElementById('new-pw').value;
    const confirmPw = document.getElementById('confirm-pw').value;

    if (!currentPw || !newPw || !confirmPw) {
        showNotify("Please fill in all password fields", "error");
        return;
    }

    if (newPw !== confirmPw) {
        showNotify("New passwords do not match", "error");
        return;
    }

    try {
        const response = await fetch('/profile/change-password', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                current_password: currentPw,
                new_password: newPw,
                new_password_confirmation: confirmPw
            })
        });

        const result = await response.json();

        if (response.ok) {
        showNotify("Password updated successfully", "success");
        
        document.getElementById("password-modal").style.display = "none";
        
        document.getElementById('current-pw').value = '';
        document.getElementById('new-pw').value = '';
        document.getElementById('confirm-pw').value = '';
    } else {
        const result = await response.json();
        showNotify(result.message || "Error updating password", "error");
    }
    } catch (error) {
        showNotify("Connection error. Try again.", "error");
    }
};

document.querySelector(".action-btn.danger").onclick = async () => {
   const isConfirmed = await Confirm("Are you sure? This will permanently delete your account and all data!");
    if (isConfirmed) {
        try {
            const response = await fetch('/profile/delete', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                window.location.href = "/";
            }
        } catch (error) {
            showNotify("Error deleting account", "error");
        }
    }
};





