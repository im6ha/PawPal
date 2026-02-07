document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('mainForm');
  if (!form) return;

  const wilaya = document.getElementById('wilaya');
  const description = document.getElementById('description');
  const hourlyPay = document.getElementById('hourlyPay');
  const charCount = document.querySelector('.char-count');

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
    const len = description.value.length;
    charCount.textContent = `${len} / ${description.getAttribute('maxlength')}`;
  };
  updateCharCount();
  description.addEventListener('input', updateCharCount);

  form.addEventListener('submit', (e) => {
    e.preventDefault();
    clearErrors();

    let isValid = true;
    let firstInvalidEl = null;

    if (!wilaya.value.trim()) {
      setError(wilaya, 'wilayaError', 'Please select a wilaya.');
      isValid = false;
      firstInvalidEl = firstInvalidEl || wilaya;
    }

    const descText = description.value.trim();
    if (!descText) {
      setError(description, 'descriptionError', 'Description is required.');
      isValid = false;
      firstInvalidEl = firstInvalidEl || description;
    } else if (descText.length < 20) {
      setError(description, 'descriptionError', 'Please provide at least 20 characters.');
      isValid = false;
      firstInvalidEl = firstInvalidEl || description;
    }

    if (!hourlyPay.value || parseFloat(hourlyPay.value) <= 0) {
      setError(hourlyPay, 'hourlyPayError', 'Hourly pay must be greater than 0.');
      isValid = false;
      firstInvalidEl = firstInvalidEl || hourlyPay;
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
