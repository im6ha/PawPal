document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('lostPetForm');
    if (!form) return;

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (validateForm()) {
            this.submit();
        }
    });

    document.querySelector('.photo-upload').addEventListener('click', function() {
        document.getElementById('petPhoto').click();
    });

    document.getElementById('petPhoto').addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const file = this.files[0];

            const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!validTypes.includes(file.type)) {
                showError(this, 'Please upload only JPG, PNG or GIF images.');
                this.value = '';
                return;
            }
            
            const maxSize = 5 * 1024 * 1024;
            if (file.size > maxSize) {
                showError(this, 'File size must be less than 5MB.');
                this.value = '';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                document.querySelector('.photo-upload i').textContent = '✅';
                document.querySelector('.photo-upload p').textContent = 'Photo uploaded successfully!';
                clearError(document.getElementById('petPhoto'));
            }
            reader.readAsDataURL(file);
        }
    });

    document.querySelectorAll('input, select, textarea').forEach(field => {
        field.addEventListener('blur', function() {
            validateField(this);
        });

        field.addEventListener('input', function() {
            if (this.classList.contains('error')) {
                clearError(this);
            }
        });

        field.addEventListener('change', function() {
            if (this.classList.contains('error')) {
                clearError(this);
            }
        });
    });
});



function validateForm() {
    let isValid = true;
    const form = document.getElementById('lostPetForm');

    const requiredFields = form.querySelectorAll('[required]');
    requiredFields.forEach(field => {
        if (!validateField(field)) {
            isValid = false;
        }
    });
    
    return isValid;
}






function validateField(field) {
    const value = field.value.trim();
    const fieldName = field.name;

    clearError(field);

    if (field.hasAttribute('required') && !value) {
        showError(field, `${getFieldLabel(field)} is required.`);
        return false;
    }

    switch (fieldName) {
        case 'petType':
            if (!value) {
                showError(field, 'Please select a pet type.');
                return false;
            }
            break;
            
        case 'wilaya':
            if (!value) {
                showError(field, 'Please select wilaya.');
                return false;
            }
            break;
            
        case 'lastSeen':
            if (value && value.length < 3) {
                showError(field, 'Please provide a more specific location (at least 3 characters).');
                return false;
            }
            break;
            
       
            
        case 'description':
            if (value && value.length < 10) {
                showError(field, 'Please provide a more detailed description (at least 10 characters).');
                return false;
            }
            break;
    }
    
    return true;
}






function showError(field, message) {
    clearError(field);

    field.classList.add('error');

    const errorElement = document.createElement('div');
    errorElement.className = 'error-message';
    errorElement.textContent = message;
    errorElement.style.cssText = `
        color: #e74c3c;
        font-size: 0.85rem;
        margin-top: 5px;
        font-weight: 500;
    `;

    field.parentNode.appendChild(errorElement);

    if (field.id === 'petPhoto') {
        document.querySelector('.photo-upload').style.borderColor = '#e74c3c';
        document.querySelector('.photo-upload').style.backgroundColor = '#fdf2f2';
    }
}

function clearError(field) {
    field.classList.remove('error');

    const existingError = field.parentNode.querySelector('.error-message');
    if (existingError) {
        existingError.remove();
    }

    if (field.id === 'petPhoto') {
        const photoUpload = document.querySelector('.photo-upload');
        photoUpload.style.borderColor = '#c5d9ed';
        photoUpload.style.backgroundColor = '#f8fafc';
    }
}

function getFieldLabel(field) {
    const label = field.parentNode.querySelector('label');
    return label ? label.textContent.replace('*', '').trim() : 'This field';
}