import { showNotification } from "../components/modal.js";

function showpassword() {
    const passwordInput = document.getElementById('password');
    const icon = document.querySelector('.showpassword');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 512 512"><path fill="#000000" fill-rule="evenodd" d="m89.752 59.582l362.667 362.667l-30.17 30.17l-59.207-59.208c-29.128 19.7-64.646 33.456-107.042 33.456C106.667 426.667 42.667 256 42.667 256s22.862-60.965 73.141-110.02L59.582 89.751zM256 85.334C405.334 85.334 469.334 256 469.334 256s-14.239 37.97-44.955 78.09l-95.84-95.863c-6.582-26.955-27.796-48.173-54.748-54.76l-85.462-85.485c20.252-7.905 42.776-12.648 67.671-12.648M181.334 256c0 41.238 33.43 74.667 74.666 74.667c12.86 0 24.959-3.25 35.522-8.975l-33.741-33.74q-.885.048-1.78.048c-17.674 0-32-14.327-32-32q0-.896.048-1.781l-33.74-33.74c-5.725 10.563-8.975 22.662-8.975 35.521"/></svg>';
    } else {
        passwordInput.type = 'password';
        icon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 24 24" fill="#000000"><g fill="#000000"><path d="M9.75 12a2.25 2.25 0 1 1 4.5 0a2.25 2.25 0 0 1-4.5 0Z"/><path fill-rule="evenodd" d="M2 12c0 1.64.425 2.191 1.275 3.296C4.972 17.5 7.818 20 12 20c4.182 0 7.028-2.5 8.725-4.704C21.575 14.192 22 13.639 22 12c0-1.64-.425-2.191-1.275-3.296C19.028 6.5 16.182 4 12 4C7.818 4 4.972 6.5 3.275 8.704C2.425 9.81 2 10.361 2 12Zm10-3.75a3.75 3.75 0 1 0 0 7.5a3.75 3.75 0 0 0 0-7.5Z" clip-rule="evenodd"/></g></svg>';
    }
}

function check_email(email) {
    if (!email || typeof email !== "string") return false;
    const emailRegex = /^[A-Za-z0-9._%+-]+@(?:[A-Za-z0-9-]+\.)+[A-Za-z]{2,}$/;
    return emailRegex.test(email);
}

document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('login-form');
    
    if (loginForm) {
        loginForm.addEventListener('submit', async function(e) {
            e.preventDefault(); 

            const email = document.getElementById('email').value;
            const password_check_el = document.getElementById('password_check');
            const email_check_el = document.getElementById('email_check');

            password_check_el.innerText = "";
            email_check_el.innerText = "";

            if (!check_email(email)) {
                email_check_el.innerText = "Please enter a valid email address.";
                return;
            }

            const formData = new FormData(this);
            const loginUrl = this.getAttribute('action'); 

            try {
                const response = await fetch(loginUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    window.location.href = "/"; 
                } else {
                    password_check_el.innerText = result.message || "Invalid credentials.";
                }
            } catch (error) {
                showNotification('Error', 'An error occurred. Please try again later.','error');
                password_check_el.innerText = "An error occurred. Please try again later.";
            }
        });
    }
});