const reportIcon = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icon-small"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" /></svg>`;
    
    const saveIcon = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="icon-small"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 .81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>`;
    
    const locationIcon = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="meta-icon"><path d="M12 2C8.134 2 5 5.134 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.866-3.134-7-7-7zM12 11.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5z"/></svg>`;
    
    const femaleIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 17 16" class="gender-icon"><path fill="#000000" fill-rule="evenodd" d="M9.982 9.965c2.243-.47 3.934-2.48 3.934-4.883c0-2.751-2.215-4.988-4.938-4.988c-2.721 0-4.936 2.237-4.936 4.988c0 2.412 1.704 4.43 3.959 4.888v2.073H5.062v1.925h2.939v2.001h1.98v-2.001h2.893v-1.925H9.981V9.965h.001zm-4.048-5.01c0-1.768 1.367-3.205 3.045-3.205c1.68 0 3.045 1.438 3.045 3.205c0 1.767-1.365 3.203-3.045 3.203c-1.678 0-3.045-1.436-3.045-3.203z"/></svg>`;
    
    const maleIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 1024 1023" class="gender-icon"><path fill="#000000" d="M955.5 477q-28.5 0-48.5-20t-20-48V223L622 488q61 88 61 194q0 93-46 171.5t-124.5 124t-171 45.5T170 977.5t-124.5-124T0 682t45.5-171.5t124.5-124T341 341q107 0 194 60l266-265H614q-28 0-48-20t-20-48t20-48t48-20h342q28 0 48 20t20 48v341q0 28-20 48t-48.5 20zm-614 0Q257 477 197 537t-60 145t60 145t144.5 60T486 827t60-145t-60-145t-144.5-60z"/></svg>`;
    
 
    // 1. Pet Card
export function createPetCard(pet) {
  const { 
    id, 
    user_id, 
    imageUrl, 
    type, 
    description, 
    location, 
    gender, 
    contactText = "Contact Owner" 
  } = pet;

  const card = document.createElement('div');
  card.className = 'card card-adopt';
  card.dataset.id = id; 

  const image = imageUrl ? 
    `<img src="${imageUrl}" alt="${type}" class="card-image">` : 
    `<div class="card-image" style="display:flex;align-items:center;justify-content:center;color:#94a3b8">${type}</div>`;

  const genderIcon = gender.toLowerCase() === 'female' ? femaleIcon : maleIcon;
  const genderBadge = `<span class="badge badge-gender">${genderIcon} ${gender}</span>`;

  card.innerHTML = `
    ${image}
    <div class="card-content card-content-adopt">
      <h3 class="card-subtitle card-subtitle-adopt">${type.toUpperCase()}</h3>
      <h2 class="card-title card-title-adopt">${description}</h2>
      <div class="meta-item">
        ${locationIcon}
        <span>${location.toUpperCase()}</span>
      </div>
      <div class="card-meta">
        ${genderBadge}
      </div>
      <div class="card-actions">
        <div class="card-icons">
          <button class="card-icon-btn save" data-id="${id}">${saveIcon}</button>
          <button class="card-icon-btn report" data-id="${id}">${reportIcon}</button>
        </div>
        <button class="contact-btn" data-id="${id}" data-owner="${user_id}">${contactText}</button>
      </div>
    </div>
  `;

  card.querySelector(".save").addEventListener('click', () => {
    card.querySelector(".save svg").classList.toggle("saved");
  });
  card.querySelector(".report").addEventListener("click", () => {
    card.querySelector(".report svg").classList.toggle("reported");
  });

  return card;
}




    // 2. Product Card
 export function createProductCard(product) {
    const card = document.createElement('div');
    card.className = 'card card-prod';
    card.dataset.id = product.id;

    const image = product.image_path ? 
        `<img src="${product.image_path}" alt="${product.name}" class="card-image">` : 
        `<div class="card-image" style="display:flex;align-items:center;justify-content:center;color:#94a3b8">${product.category}</div>`;

    card.innerHTML = `
        ${image}
        <div class="card-content card-content-prod">
            <h3 class="card-subtitle card-subtitle-prod">${product.category.toUpperCase()} | ${product.pet_type.toUpperCase()}</h3>
            <h2 class="card-title card-title-prod">${product.name.toUpperCase()}</h2>
            <p class="card-description card-description-prod">${product.description}</p>
            <p class="card-title card-title-prod" style="color:rgba(87, 26, 125, 1);margin-top:8px">${product.price} DA</p>
            <div class="meta-item">
                ${locationIcon}
                <span>${(product.wilaya_name || 'Unknown').toUpperCase()}</span>
            </div>
            <div class="card-actions">
                <div class="card-icons">
                    <button class="card-icon-btn save" data-id="${product.id}">${saveIcon}</button>
                    <button class="card-icon-btn report" data-id="${product.id}">${reportIcon}</button>
                </div>
                <button class="contact-btn" data-id="${product.id}" data-owner="${product.user_id}">Contact Seller</button>
            </div>
        </div>
    `;

    card.querySelector(".save").addEventListener('click', () => {
        card.querySelector(".save svg").classList.toggle("saved");
    });

    card.querySelector(".report").addEventListener("click", () => {
        card.querySelector(".report svg").classList.toggle("reported");
    });

    return card;
}
    
   // 3. Lost & Found Card
export function createLostFoundCard(lostFound) {
  const { 
    id,
    user_id,
    imageUrl, 
    type, 
    description, 
    location, 
    lastSeen, 
    status, 
    contactText = "Contact Finder" 
  } = lostFound;


  const card = document.createElement('div');
  card.className = 'card card-lost';
  card.dataset.id = id;

  const image = imageUrl ? 
    `<img src="${imageUrl}" alt="${type}" class="card-image">` : 
    `<div class="card-image" style="display:flex;align-items:center;justify-content:center;color:#94a3b8">${status}</div>`;

  const statusBadge =`<span class="badge badge-lost">LOST</span>` ;

  card.innerHTML = `
    ${image}
    <div class="card-content card-content-lost">
      <h3 class="card-subtitle card-subtitle-lost">${type.toUpperCase()}</h3>
      <h2 class="card-title card-title-lost">${description}</h2>
      <div class="meta-item">
        ${locationIcon}
        <span>${location.toUpperCase()}</span>
      </div>
      <div class="card-meta">
        <span class="meta-item">Last seen: ${lastSeen.toUpperCase()}</span>
        ${statusBadge}
      </div>
      <div class="card-actions">
        <div class="card-icons">
          <button class="card-icon-btn save" data-id="${id}">${saveIcon}</button>
          <button class="card-icon-btn report" data-id="${id}">${reportIcon}</button>
        </div>
        <button class="contact-btn" data-id="${id}" data-owner="${user_id}">${contactText}</button>
      </div>
    </div>
  `;

  card.querySelector(".save").addEventListener('click', () => {
    card.querySelector(".save svg").classList.toggle("saved");
  });
  card.querySelector(".report").addEventListener("click", () => {
    card.querySelector(".report svg").classList.toggle("reported");
  });

  return card;
}
















    // 4. Service Card
export function createServiceCard(service) {
  const { 
    id,
    user_id,
    name, 
    location, 
    description, 
    fee, 
    avatarUrl 
  } = service;

  const card = document.createElement('div');
  card.className = 'card card-service';
  card.dataset.id = id;

  const avatar = avatarUrl ? 
    `<img src="${avatarUrl}" alt="${name}" class="service-avatar">` :
    `<div class="service-avatar" style="display:flex;align-items:center;justify-content:center;font-weight:bold;color:#64748b">${name.charAt(0)}</div>`;

  card.innerHTML = `
    <div class="card-content card-content-service">
      <div class="service-header">
        ${avatar}
        <div class="service-info">
          <h3>${name.toUpperCase()}</h3>
          <p>${location.toUpperCase()}</p>
        </div>
      </div>
      <p class="card-description card-description-service">${description}</p>
      <p class="service-fee">${fee}<span style="font-size:0.6rem;font-weight:400;">DA/24h</span></p>
      <div class="card-actions">
        <div class="card-icons">
          <button class="card-icon-btn save" data-id="${id}">${saveIcon}</button>
          <button class="card-icon-btn report" data-id="${id}">${reportIcon}</button>
        </div>
        <button class="contact-btn" data-id="${id}" data-owner="${user_id}">Hire Now</button>
      </div>
    </div>
  `;

  card.querySelector(".save").addEventListener('click', () => {
    card.querySelector(".save svg").classList.toggle("saved");
  });
  card.querySelector(".report").addEventListener("click", () => {
    card.querySelector(".report svg").classList.toggle("reported");
  });

  return card;
}