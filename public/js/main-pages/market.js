import { createCategoryFilter, createLocationFilter, createPriceFilter, createPetFilter, setupFilterBehavior } from "../components/filters.js";
import { createProductCard } from "../components/cards.js";
import { showNotification } from "../components/modal.js";

document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("filter-pet").appendChild(createPetFilter());
    document.getElementById("filter-category").appendChild(createCategoryFilter());
    document.getElementById("filter-price").appendChild(createPriceFilter());
    document.getElementById("filter-location").appendChild(createLocationFilter());
    setupFilterBehavior();

    loadProducts();

    document.getElementById("add-product").addEventListener("click", () => {
        window.location.href = "/market/add-product";
    });
});

//==========
function getActiveFilters() {
    const filters = {
        categories: [],
        locations: [],
        pet_types: [],
        min_price: document.getElementById('start')?.value,
        max_price: document.getElementById('end')?.value
    };

document.querySelectorAll('#category-dropdown input:checked').forEach(el => {
    filters.categories.push(el.value);
});

document.querySelectorAll('#wilaya-dropdown input:checked').forEach(el => {
    filters.locations.push(el.value);
});

document.querySelectorAll('#pet-dropdown input:checked').forEach(el => {
    filters.pet_types.push(el.value);
});

    return filters;
}

async function loadProducts() {
    const filters = getActiveFilters();
    const params = new URLSearchParams();

    if (filters.categories.length) params.append('categories', filters.categories.join(','));
    if (filters.locations.length) params.append('locations', filters.locations.join(','));
    if (filters.min_price) params.append('min_price', filters.min_price);
    if (filters.max_price) params.append('max_price', filters.max_price);
    if (filters.pet_types.length) params.append('pet_types', filters.pet_types.join(','));

    const response = await fetch(`/api/products?${params.toString()}`);
    const products = await response.json();
    const container = document.getElementById('products-list');
    container.innerHTML = "";

        if (products.length === 0) {
            container.innerHTML = "<p>No products found in the market.</p>";
            return;
        }

        products.forEach(product => {
            const card = createProductCard(product);
            container.appendChild(card);
        });


}

document.addEventListener('change', (e) => {
    if (e.target.tagName === 'INPUT') {
        loadProducts();
    }
});



//======

const productList = document.getElementById('products-list');

productList.addEventListener('click', async (e) => {
    const btn = e.target.closest('button');
    if (!btn) return;

    const productId = btn.dataset.id;
    const ownerId = btn.dataset.owner;
    let endpoint, body;

    if (btn.classList.contains('save')) {
        endpoint = '/api/saved-posts/toggle';
        body = { saveable_id: productId, saveable_type: 'products' };
    } else if (btn.classList.contains('report')) {
        endpoint = '/api/reports';
        body = { reportable_id: productId, post_type: 'products' };
    } else if (btn.classList.contains('contact-btn')) {
        endpoint = '/api/service-requests';
        body = { 
            receiver_id: ownerId, 
            requestable_id: productId, 
            requestable_type:'products' 
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
    showNotification('Error', 'An error occurred. Please try again later.','error');
    }
}); 