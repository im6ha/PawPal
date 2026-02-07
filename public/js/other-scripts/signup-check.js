import { showNotification } from "../components/modal.js";
const full_name = document.getElementById("full-name");
const email = document.getElementById("email");
const phone_number = document.getElementById("phone-name");
const password = document.getElementById("password");
const confirm = document.getElementById("confirm-password");

function check_email(x) {
    let email_parts = x.split("@");
    if (email_parts.length != 2) return false;
    if (
        /^[A-Za-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[A-Za-z0-9!#$%&'*+/=?^_`{|}~-]+)*$/.test(
            email_parts[0],
        ) == false
    )
        return false;
    let second_email_parts = email_parts[1].split(".");
    if (second_email_parts.length < 2) return false;
    if (/^[A-Za-z0-9-]{1,20}$/.test(second_email_parts[0]) == false)
        return false;
    if (
        /^[A-Za-z]{2,24}$/.test(
            second_email_parts[second_email_parts.length - 1],
        ) == false
    )
        return false;
    return true;
}

function check_name(x) {
    let first_last_names = x.split(" ");
    if (first_last_names.length < 2 || first_last_names.length > 5)
        return false;
    for (const name of first_last_names) {
        if (/^[A-Za-z]{1,20}$/.test(name) == false) return false;
    }
    return true;
}

function check_phone(x) {
    return /^0\d{9}$/.test(x);
}

function check_password(x) {
    return /^(?=.*[A-Za-z])(?=.*\d)(?=.*[\/\*\.\?\$])[A-Za-z\d\/\*\.\?\$]{8,20}$/.test(
        x,
    );
}

function check_confirm(x, y) {
    return x === y;
}

document.getElementById("signup-form").addEventListener("submit", function (e) {
    e.preventDefault();

    document
        .querySelectorAll('[id$="-ch"]')
        .forEach((el) => (el.textContent = ""));

    let valid = true;
    if (!check_name(full_name.value)) {
        document.getElementById("full-name-ch").textContent =
            "Enter a valid full name";
        valid = false;
    }
    if (!check_email(email.value)) {
        document.getElementById("email-ch").textContent = "Enter a valid email";
        valid = false;
    }
    if (!check_phone(phone_number.value)) {
        document.getElementById("phone-ch").textContent =
            "Enter a valid phone number (10 digits)";
        valid = false;
    }
    if (!check_password(password.value)) {
        document.getElementById("password-ch").textContent =
            "Password: letters, numbers, and one of (/ * . ? $) (8-20 chars)";
        valid = false;
    }
    if (!check_confirm(password.value, confirm.value)) {
        document.getElementById("confirm-password-ch").textContent =
            "Passwords do not match";
        valid = false;
    }

    if (!valid) return;

    
    
    const formData = new FormData(this);

    fetch(window.SIGNUP_URL, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(async res => {
        const data = await res.json();
        if (res.ok && data.success) {
            window.location.href = "/";
        } else {
            const errorMsg = data.errors ? Object.values(data.errors).flat().join('\n') : (data.message || "Signup failed");
            showNotification('Error', errorMsg, 'error');
        }
    })
    .catch(err => {
        showNotification('Error', 'An error occurred during signup. Please try again later.', 'error');
    });
});


