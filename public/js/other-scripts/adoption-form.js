document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('mainForm');
  if (!form) return;

  const petType = document.getElementById('petType');
  const wilaya = document.getElementById('wilaya');
  const description = document.getElementById('description');
  const charCount = document.querySelector('.char-count');
  const fileInput = document.getElementById('petPhoto');
  const fileName = document.getElementById('fileName');

  const clearErrors = () => {
    document.querySelectorAll('.error').forEach(el => el.textContent = '');
    document.querySelectorAll('.invalid').forEach(el => el.classList.remove('invalid'));
  };

  const setError = (inputEl, errorSpanId, message) => {
    const span = document.getElementById(errorSpanId);
    if (span) span.textContent = message;
    if (inputEl) inputEl.classList.add('invalid');
  };

  const updateCharCount = () => {
    if (!charCount || !description) return;
    const len = description.value.length;
    charCount.textContent = `${len} / ${description.getAttribute('maxlength') || 100} characters`;
  };
  updateCharCount();

  if (description && charCount) {
    description.addEventListener('input', updateCharCount);
  }

  if (fileInput && fileName) {
    fileInput.addEventListener('change', () => {
      fileName.textContent = fileInput.files.length > 0 ? fileInput.files[0].name : 'No file chosen';
    });
  }

  form.addEventListener('submit', (e) => {
    e.preventDefault();
    clearErrors();

    let isValid = true;
    let firstInvalidEl = null;
    if (!petType.value.trim()) {
      setError(petType, 'petTypeError', 'This field is required.');
      isValid = false;
      firstInvalidEl = firstInvalidEl || petType;
    }

    if (!wilaya.value.trim()) {
      setError(wilaya, 'wilayaError', 'This field is required.');
      isValid = false;
      firstInvalidEl = firstInvalidEl || wilaya;
    }

    const genderChecked = document.querySelector('input[name="petGender"]:checked');
    if (!genderChecked) {
      const radio = document.querySelector('input[name="petGender"]');
      setError(radio, 'genderError', 'This field is required.');
      if (radio) radio.parentElement.classList.add('invalid'); 
      isValid = false;
      firstInvalidEl = firstInvalidEl || radio;
    }

    const descText = description.value.trim();
    if (!descText) {
      setError(description, 'descriptionError', 'This field is required.');
      isValid = false;
      firstInvalidEl = firstInvalidEl || description;
    } else if (descText.length < 20) {
      setError(description, 'descriptionError', 'Please provide at least 20 characters.');
      isValid = false;
      firstInvalidEl = firstInvalidEl || description;
    } else if (descText.length > 100) {
      setError(description, 'descriptionError', 'Too long. Keep it under 100 characters.');
      isValid = false;
      firstInvalidEl = firstInvalidEl || description;
    }

    if (!fileInput.files || fileInput.files.length === 0) {
      setError(fileInput, 'photoError', 'This field is required.');
      isValid = false;
      firstInvalidEl = firstInvalidEl || fileInput;
    } else {
      const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
      if (!allowedTypes.includes(fileInput.files[0].type)) {
        setError(fileInput, 'photoError', 'Only JPG, PNG, or WebP images are allowed.');
        isValid = false;
        firstInvalidEl = firstInvalidEl || fileInput;
      }
    }

    if (!isValid) {
      if (firstInvalidEl) {
        firstInvalidEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
        firstInvalidEl.focus && firstInvalidEl.focus();
      }
      return;
    }
    form.submit();
  });
});
