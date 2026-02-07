import { createLocationFilter, createPriceFilter, setupFilterBehavior } from "../components/filters.js";
import { createServiceCard } from "../components/cards.js";
import { showNotification } from "../components/modal.js";

document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("filter-location").appendChild(createLocationFilter());
    document.getElementById("filter-price").appendChild(createPriceFilter());
    setupFilterBehavior();

    loadSitters();

    const applyBtn = document.querySelector('.create-post');
    if (applyBtn) {
        applyBtn.addEventListener("click", () => {
            window.location.href = "/sitter-form";
        });
    }
});

function getActiveFilters() {
    const filters = {
        locations: [],
        min_price: document.getElementById('start')?.value,
        max_price: document.getElementById('end')?.value
    };

    document.querySelectorAll('#wilaya-dropdown input:checked').forEach(el => {
        filters.locations.push(el.value);
    });

    return filters;
}

async function loadSitters() {
    const filters = getActiveFilters();
    const params = new URLSearchParams();

    if (filters.locations.length) params.append('locations', filters.locations.join(','));
    if (filters.min_price) params.append('min_price', filters.min_price);
    if (filters.max_price) params.append('max_price', filters.max_price);

    const response = await fetch(`/api/sitters?${params.toString()}`);
    const sitters = await response.json();
    const container = document.getElementById('sitters-grid');
    container.innerHTML = "";

    if (sitters.length === 0) {
        container.innerHTML = "<p>No sitters available in your area.</p>";
        return;
    }

    sitters.forEach(sitter => {
        const card = createServiceCard(sitter);
        container.appendChild(card);
    });
}

document.addEventListener('change', (e) => {
    if (e.target.tagName === 'INPUT') {
        loadSitters();
    }
});

const sittersGrid = document.getElementById('sitters-grid');

sittersGrid.addEventListener('click', async (e) => {
    const btn = e.target.closest('button');
    if (!btn) return;

    const sitterId = btn.dataset.id;
    const ownerId = btn.dataset.owner;
    let endpoint, body;

    if (btn.classList.contains('save')) {
        endpoint = '/api/saved-posts/toggle';
        body = { saveable_id: sitterId, saveable_type: 'sitters' };
    } else if (btn.classList.contains('report')) {
        endpoint = '/api/reports';
        body = { reportable_id: sitterId, post_type: 'sitters' };
    } else if (btn.classList.contains('contact-btn')) {
        endpoint = '/api/service-requests';
        body = { 
            receiver_id: ownerId, 
            requestable_id: sitterId, 
            requestable_type: 'sitters' 
        };
    } else {
        return;
    }

    try {
        const response = await fetch(endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
            },
            body: JSON.stringify(body)
        });

        if (response.status === 401) {
            window.location.href = '/login-page';
            return;
        }

        if (response.ok) {
            const data = await response.json();
            showNotification('Success', data.message);
        }
    } catch (error) {
        showNotification('Error', 'An error occurred. Please try again later.', 'error');
    }
});
