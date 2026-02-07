import { createPetFilter, createLocationFilter, createGenderFilter, setupFilterBehavior } from "../components/filters.js";
import { createPetCard } from "../components/cards.js";
import { showNotification } from "../components/modal.js";

document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("filter-pet").appendChild(createPetFilter());
    document.getElementById("filter-location").appendChild(createLocationFilter());
    document.getElementById("filter-gender").appendChild(createGenderFilter());
    setupFilterBehavior();

    loadPets();

    document.getElementById("add-adoption").addEventListener("click", () => {
        window.location.href = "/adoption-form";
    });
});

function getActiveFilters() {
    const filters = {
        pet_types: [],
        locations: [],
        genders: []
    };

    document.querySelectorAll('#pet-dropdown input:checked').forEach(el => {
        filters.pet_types.push(el.value.toLowerCase());
    });

    document.querySelectorAll('#wilaya-dropdown input:checked').forEach(el => {
        filters.locations.push(el.value);
    });

    document.querySelectorAll('#gender-dropdown input:checked').forEach(el => {
        filters.genders.push(el.value.toLowerCase());
    });

    return filters;
}

async function loadPets() {
    const filters = getActiveFilters();
    const params = new URLSearchParams();

    if (filters.pet_types.length) params.append('pet_types', filters.pet_types.join(','));
    if (filters.locations.length) params.append('locations', filters.locations.join(','));
    if (filters.genders.length) params.append('genders', filters.genders.join(','));

    const response = await fetch(`/api/adoptions?${params.toString()}`);
    const pets = await response.json();
    const container = document.getElementById('pets-list');
    container.innerHTML = "";

    if (pets.length === 0) {
        container.innerHTML = "<p>No pets available for adoption.</p>";
        return;
    }

    pets.forEach(pet => {
        const card = createPetCard(pet);
        container.appendChild(card);
    });
}

document.addEventListener('change', (e) => {
    if (e.target.tagName === 'INPUT') {
        loadPets();
    }
});

const petsList = document.getElementById('pets-list');

petsList.addEventListener('click', async (e) => {
    const btn = e.target.closest('button');
    if (!btn) return;

    const petId = btn.dataset.id;
    const ownerId = btn.dataset.owner;
    let endpoint, body;

    if (btn.classList.contains('save')) {
        endpoint = '/api/saved-posts/toggle';
        body = { saveable_id: petId, saveable_type: 'adoption' };
    } else if (btn.classList.contains('report')) {
        endpoint = '/api/reports';
        body = { reportable_id: petId, post_type: 'adoption' };
    } else if (btn.classList.contains('contact-btn')) {
        endpoint = '/api/service-requests';
        body = { 
            receiver_id: ownerId, 
            requestable_id: petId, 
            requestable_type: 'adoptions' 
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
