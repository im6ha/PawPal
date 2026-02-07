import { createPetFilter, createLocationFilter, setupFilterBehavior } from "../components/filters.js";
import { createLostFoundCard } from "../components/cards.js";
import { showNotification } from "../components/modal.js";

document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("filter-pet").appendChild(createPetFilter());
    document.getElementById("filter-location").appendChild(createLocationFilter());
    setupFilterBehavior();

    loadLostPets();
});





function getActiveFilters() {
    const filters = {
        pet_types: [],
        locations: [],
    };

    document.querySelectorAll('#pet-dropdown input:checked').forEach(el => {
        filters.pet_types.push(el.value);
    });

    document.querySelectorAll('#wilaya-dropdown input:checked').forEach(el => {
        filters.locations.push(el.value);
    });

    

    return filters;
}






async function loadLostPets() {
    const filters = getActiveFilters();
    const params = new URLSearchParams();

    if (filters.pet_types.length) params.append('pet_types', filters.pet_types.join(','));
    if (filters.locations.length) params.append('locations', filters.locations.join(','));

    const response = await fetch(`/api/lost-pets?${params.toString()}`);
    const lostPets = await response.json();
    const container = document.getElementById('reports-grid');
    container.innerHTML = "";

    if (lostPets.length === 0) {
        container.innerHTML = "<p>No lost pets reports found.</p>";
        return;
    }

    lostPets.forEach(pet => {
        const card = createLostFoundCard(pet);
        container.appendChild(card);
    });
}

document.addEventListener('change', (e) => {
    if (e.target.tagName === 'INPUT') {
        loadLostPets();
    }
});







const reportsGrid = document.getElementById('reports-grid');

reportsGrid.addEventListener('click', async (e) => {
    const btn = e.target.closest('button');
    if (!btn) return;

    const petId = btn.dataset.id;
    const ownerId = btn.dataset.owner;
    let endpoint, body;

    if (btn.classList.contains('save')) {
        endpoint = '/api/saved-posts/toggle';
        body = { saveable_id: petId, saveable_type: 'lost-pets' };
    } else if (btn.classList.contains('report')) {
        endpoint = '/api/reports';
        body = { reportable_id: petId, post_type: 'lost-pets' };
    } else if (btn.classList.contains('contact-btn')) {
        endpoint = '/api/service-requests';
        body = { 
            receiver_id: ownerId, 
            requestable_id: petId, 
            requestable_type: 'lost-pets' 
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