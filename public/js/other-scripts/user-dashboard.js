const user_id = window.CURRENT_USER_ID;
//=======================Saved Posts========================
import { createPetCard as _createPetCard } from "../components/cards.js";
import { createProductCard as _createProductCard } from "../components/cards.js";
import { createLostFoundCard as _createLostFoundCard } from "../components/cards.js";
import { createServiceCard as _createServiceCard } from "../components/cards.js";

function markAsSaved(cardElement) {
    const saveBtn = cardElement.querySelector(".card-icon-btn.save");
    if (saveBtn) {
        saveBtn.classList.add("active");
        const svg = saveBtn.querySelector("svg");
        if (svg) svg.classList.add("saved");
    }
}
function createSavedPetCard(
    postId,
    imageUrl,
    type,
    description,
    location,
    gender,
) {
    const card = _createPetCard({
        id: postId,
        user_id: user_id,
        imageUrl: imageUrl,
        type: type,
        description: description,
        location: location,
        gender: gender,
        contactText: "Contact Owner",
    });
    card.dataset.postId = postId;
    markAsSaved(card);
    card.classList.add("saved-card");
    return card;
}

function createSavedProductCard(
    postId,
    imageUrl,
    petType,
    category,
    productName,
    description,
    price,
    location,
) {
    const productData = {
        id: postId,
        user_id: user_id,
        image_path: imageUrl,
        pet_type: petType,
        category: category,
        name: productName,
        description: description,
        price: price,
        wilaya_name: location,
    };
    const card = _createProductCard(productData);
    card.dataset.postId = postId;
    markAsSaved(card);
    card.classList.add("saved-card");
    return card;
}

function createSavedLostPetCard(
    postId,
    imageUrl,
    type,
    description,
    location,
    lastSeen,
    status,
) {
    const card = _createLostFoundCard({
        id: postId,
        user_id: user_id,
        imageUrl: imageUrl,
        type: type,
        description: description,
        location: location,
        lastSeen: lastSeen,
        status: status,
        contactText: "Contact Finder",
    });
    card.dataset.postId = postId;
    markAsSaved(card);
    card.classList.add("saved-card");
    return card;
}

function createSavedServiceCard(
    postId,
    name,
    location,
    supportedPets,
    description,
    fee,
    avatarUrl,
) {
    const card = _createServiceCard({
        id: postId,
        user_id: user_id,
        name: name,
        location: location,
        description: description,
        fee: fee,
        avatarUrl: avatarUrl,
    });
    card.dataset.postId = postId;
    markAsSaved(card);
    card.classList.add("saved-card");
    return card;
}

async function renderSavedCards(subTab) {
    const container = document.getElementById(`saved-${subTab}-grid`);
    if (!container) return;

    container.innerHTML = '<div class="loading">Loading...</div>';

    try {
        const response = await fetch(`/dashboard/saved/${subTab}`);
        const result = await response.json();
        const items = result.data || [];

        if (items.length === 0) {
            container.innerHTML = `<div class="empty-state"><h3>No saved ${subTab} yet</h3></div>`;
            return;
        }

        container.innerHTML = "";
        items.forEach((item) => {
            let card;
            const displayLocation = item.wilaya_name || "Unknown";
            if (subTab === "adoption") {
                card = createSavedPetCard(
                    item.id,
                    item.image_path,
                    item.pet_type,
                    item.description,
                    displayLocation,
                    item.gender,
                );
            } else if (subTab === "products") {
                card = createSavedProductCard(
                    item.id,
                    item.image_path,
                    item.pet_type,
                    item.category,
                    item.name,
                    item.description,
                    item.price,
                    displayLocation,
                );
            } else if (subTab === "sitters") {
                card = createSavedServiceCard(
                    item.id,
                    item.user ? item.user.name : "Pet Sitter",
                    displayLocation,
                    "",
                    item.bio,
                    item.fee_per_day,
                    item.profile_image_path,
                );
            } else if (subTab === "lost-pets") {
                card = createSavedLostPetCard(
                    item.id,
                    item.image_path,
                    item.pet_type,
                    item.description,
                    displayLocation,
                    item.last_seen_area || "Unknown",
                    item.status,
                );
            }

            if (card) {
                card.dataset.id = item.id;
                container.appendChild(card);
            }
        });
    } catch (error) {
        container.innerHTML = '<div class="error">Failed to load items.</div>';
    }
}

function setupSavedListeners() {
    const savedSection = document.getElementById("saved");
    if (!savedSection) return;

    savedSection.addEventListener("click", (e) => {
        const saveBtn = e.target.closest(".card-icon-btn.save");
        if (saveBtn) {
            const card = saveBtn.closest(".card");

            const id = card.dataset.id;

            const activeSubBtn = savedSection.querySelector(
                ".sub-tab-btn.active",
            );
            const activeSubTab = activeSubBtn
                ? activeSubBtn.dataset.subtab
                : null;

            if (id && activeSubTab) {
                handleUnsaveItem(id, activeSubTab);
            }
        }
    });
}

async function handleUnsaveItem(id, subTab) {
    const confirmed = await showConfirmationModal(
        "Remove Saved?",
        "Remove this from your list?",
        "Remove",
        "bg-red-500",
    );

    if (confirmed) {
        try {
            const response = await fetch("/dashboard/unsave", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                body: JSON.stringify({ id: id, type: subTab }),
            });

            const result = await response.json();

            if (response.ok) {
                notify(result.message || "Item removed", "success");
                renderSavedCards(subTab);
                if (typeof updateStats === "function") updateStats();
                refreshAfterAction();
            } else {
                notify(result.error || "Failed to remove", "error");
            }
        } catch (error) {
            notify("Error connecting to server", "error");
        }
    }
}

//=====================My requests sent========================

async function renderMyRequests(subTab) {
    const container = document.getElementById(`requests-${subTab}-container`);
    if (!container) return;

    container.innerHTML = '<div class="loading">Loading...</div>';

    try {
        const response = await fetch(`/dashboard/requests-sent/${subTab}`);
        const result = await response.json();
        const requests = result.data || [];

        if (requests.length === 0) {
            container.innerHTML = `<div class="empty-state"><h3>No ${subTab.replace("-", " ")} requests sent yet.</h3></div>`;
            return;
        }

        container.innerHTML = "";
        requests.forEach((req) => {
            const item = req.requestable;
            const div = document.createElement("div");
            div.className = "request-list-item";
            div.dataset.id = req.id;

            const title = item
                ? item.name || item.pet_type || "Service Request"
                : "Deleted Post";
            const imgSrc = item
                ? item.image_path ||
                  item.profile_image_path ||
                  "/media/images/default.png"
                : "/media/images/default.png";

            div.innerHTML = `
        <div class="req-info">
        <img src="${imgSrc}" alt="Item" onerror="this.src='/media/images/default.png'">
        <div class="req-details">
            <h4>${title.toUpperCase()}</h4>
            <p><i class="fas fa-calendar-alt"></i> Sent: ${new Date(req.created_at).toLocaleDateString()}</p>
        </div>
        </div>
        <div class="req-status-wrapper">
        <span class="status-badge status-${req.status}">${req.status.toUpperCase()}</span>
        ${
            req.status === "pending"
                ? `<button class="cancel-req-btn" data-action="cancel">
            <i class="fas fa-times"></i> Cancel
            </button>`
                : ""
        }
        </div>
        `;
            container.appendChild(div);
        });
    } catch (error) {
        container.innerHTML =
            '<div class="error">Failed to load requests.</div>';
    }
}

function setupRequestsSentListeners() {
    const section = document.getElementById("my-requests");
    if (!section) return;

    section.addEventListener("click", (e) => {
        const target = e.target.closest("[data-action]");
        if (!target) return;

        const listItem = target.closest(".request-list-item");
        if (!listItem) return;

        const reqId = listItem.dataset.id;
        const action = target.dataset.action;

        if (action === "cancel") {
            const activeBtn = section.querySelector(".sub-tab-btn.active");
            const subTab = activeBtn ? activeBtn.dataset.subtab : "adoption";
            handleCancelRequest(reqId, subTab);
        }
    });
}

async function handleCancelRequest(requestId, subTab) {
    const confirmed = await showConfirmationModal(
        "Cancel Request?",
        "Are you sure you want to cancel this request? This action cannot be undone.",
        "Yes, Cancel",
        "bg-red-600",
    );

    if (!confirmed) return;

    try {
        const response = await fetch("/dashboard/requests/cancel", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: JSON.stringify({ id: requestId }),
        });

        if (response.ok) {
            notify("Request cancelled", "success");
            renderMyRequests(subTab);
            if (typeof updateStats === "function") updateStats();
            refreshAfterAction();
        } else {
            const result = await response.json();
            notify(result.error || "Failed to cancel request", "error");
        }
    } catch (error) {
        notify("Error connecting to server", "error");
    }
}

//=====================My posts and incoming requests========================

function renderHardcodedPost(subTab, post) {
    let innerHTML = "";
    if (subTab === "adoption") {
        innerHTML = `
      <div class="card-image-wrapper">
<img src="${post.image_path}" onerror="this.src='/media/images/default.png'">        <div class="card-badge">${post.pet_type}</div>
      </div>
      <div class="card-content">
        <p>${post.description}</p>
        <div class="meta-item"><i class="fas fa-venus-mars"></i> ${post.gender}</div>
      </div>`;
    } else if (subTab === "products") {
        innerHTML = `
      <div class="card-image-wrapper">
<img src="${post.image_path}" onerror="this.src='/media/images/default.png'">        <div class="card-badge">${post.category}</div>
      </div>
      <div class="card-content">
        <h3>${post.name}</h3>
        <p>${post.price} DA</p>
      </div>`;
    } else if (subTab === "sitters") {
        innerHTML = `
  <div class="card-image-wrapper">
<img src="${post.profile_image_path}" onerror="this.src='/media/images/default.png'">  </div>
  <div class="card-content">
    <h3>Your Sitter Profile</h3>
    <p>${post.bio}</p>
    <p><strong>Fee:</strong> ${post.fee_per_day} DA/day</p>
  </div>`;
    } else if (subTab === "lost-pets") {
        innerHTML = `
      <div class="card-image-wrapper">
<img src="${post.image_path}" onerror="this.src='/media/images/default.png'">        <div class="card-badge">${post.status}</div>
      </div>
      <div class="card-content">
        <p>${post.description}</p>
        <p><strong>Last seen:</strong> ${post.last_seen_area}</p>
      </div>`;
    }
    return innerHTML;
}

async function renderMyPosts(subTab) {
    const container = document.getElementById(`posts-${subTab}-grid`);
    if (!container) return;

    container.innerHTML = '<div class="loading">Loading...</div>';

    try {
        const response = await fetch(`/dashboard/my-posts/${subTab}`);
        const result = await response.json();
        const posts = result.data || [];

        if (posts.length === 0) {
            container.innerHTML = `<div class="empty-state"><i class="fas fa-paw empty-state-icon"></i><h3>No posts created yet</h3></div>`;
            return;
        }

        container.innerHTML = "";
        posts.forEach((post) => {
            const card = document.createElement("div");
            card.className = "card my-post-card";
            card.dataset.id = post.id;

            let innerHTML = "";
            if (subTab === "adoption") {
                innerHTML = `<div class="card-image-wrapper"><img src="${post.image_path}"><div class="card-badge">${post.pet_type}</div></div>
                        <div class="card-content"><p>${post.description}</p></div>`;
            } else if (subTab === "products") {
                innerHTML = `<div class="card-image-wrapper"><img src="${post.image_path}"><div class="card-badge">${post.category}</div></div>
                      <div class="card-content"><h3>${post.name}</h3></div>`;
            } else if (subTab === "sitters") {
                innerHTML = `<div class="card-content"><h3>Your Sitter Profile</h3><p>${post.bio}</p></div>`;
            } else if (subTab === "lost-pets") {
                innerHTML = `<div class="card-image-wrapper"><img src="${post.image_path}"></div>
                <div class="card-content"><p>${post.description}</p></div>`;
            }
            if (post.incoming_count > 0) {
                const badgePosition =
                    subTab === "sitters" || subTab === "lost-pets" ? 'style="top: 10px"' : "";
                innerHTML += `<div class="incoming-request-badge" ${badgePosition}><i class="fas fa-inbox"></i> ${post.incoming_count}</div>`;
            }

            card.innerHTML = innerHTML;
            container.appendChild(card);
        });
    } catch (error) {
        container.innerHTML =
            '<div class="error">Error loading your posts.</div>';
    }
}

async function openPostDetails(postId, subTab) {
    const view = document.getElementById(`posts-${subTab}-view`);
    const reqContainer = document.getElementById(
        `incoming-${subTab}-container`,
    );
    const countSpan = document.getElementById(`incoming-count-${subTab}`);
    const wrapper = view.querySelector(".single-post-card-wrapper");

    try {
        const response = await fetch(
            `/dashboard/post-requests/${subTab}/${postId}`,
        );
        const result = await response.json();
        const { post, requests } = result;

        view.dataset.viewState = "details";
        countSpan.textContent = requests.length;

        wrapper.innerHTML = "";
        const postCard = document.createElement("div");
        postCard.className = "card my-post-card";
        postCard.dataset.id = post.id;
        postCard.innerHTML = renderHardcodedPost(subTab, post);
        wrapper.appendChild(postCard);

        reqContainer.innerHTML = "";
        if (requests.length === 0) {
            reqContainer.innerHTML =
                '<p class="empty-small">No incoming requests yet.</p>';
            return;
        }

        requests.forEach((req) => {
            const item = document.createElement("div");
            item.className = "request-list-item incoming";
            item.dataset.requestId = req.id;
            item.dataset.postId = postId;

            const statusClass = `status-${req.status}`;
            const showContact = req.status === "accepted" && req.sender.phone;

            item.innerHTML = `
        <div class="request-info">
          <div class="requester-details">
            <span class="requester-name">${req.sender.name}</span>
            ${showContact ? `<span class="requester-contact">Phone: ${req.sender.phone}</span>` : ""}
          </div>
        </div>
        <span class="request-status ${statusClass}">${req.status}</span>
        <div class="request-actions">
          ${
              req.status === "pending"
                  ? `
            <button class="request-action-btn accept-btn" data-action="accept" data-request-id="${req.id}">Accept</button>
            <button class="request-action-btn refuse-btn" data-action="refuse" data-request-id="${req.id}">Refuse</button>
          `
                  : ""
          }
        </div>
      `;
            reqContainer.appendChild(item);
        });
    } catch (error) {
        notify("Error loading post details", "error");
    }
}

async function handleIncomingRequest(postId, requestId, subTab, action) {
    const title = action === "accept" ? "Accept Request?" : "Refuse Request?";
    const color = action === "accept" ? "bg-green-600" : "bg-red-600";

    const confirmed = await showConfirmationModal(
        title,
        `Confirm ${action}?`,
        action.toUpperCase(),
        color,
    );

    if (confirmed) {
        try {
            const response = await fetch("/dashboard/requests/handle", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                body: JSON.stringify({ request_id: requestId, action: action }),
            });

            if (response.ok) {
                openPostDetails(postId, subTab);
                notify(`Request ${action}ed`, "success");
            }
        } catch (error) {
            notify("Error processing request", "error");
        }
    }
}

function setupMyPostsListeners() {
    const section = document.getElementById("my-posts");
    if (!section) return;

    section.addEventListener("click", (e) => {
        const target = e.target;

        const postCard = target.closest(".my-post-card");
        if (postCard && !target.closest(".post-details-view")) {
            const subTab = postCard
                .closest(".sub-tab-content")
                .id.replace("posts-", "");
            openPostDetails(postCard.dataset.id, subTab);
            return;
        }

        const actionBtn = target.closest(".accept-btn, .refuse-btn");
        if (actionBtn) {
            const item = actionBtn.closest(".request-list-item");
            const action = actionBtn.dataset.action;
            const subTab = item
                .closest(".sub-tab-content")
                .id.replace("posts-", "");
            handleIncomingRequest(
                item.dataset.postId,
                item.dataset.requestId,
                subTab,
                action,
            );
            return;
        }

        const dltBtn = target.closest(".btn-dlt");
        if (dltBtn) {
            const view = dltBtn.closest(".post-management-view");
            const subTab = view.id.replace("posts-", "").replace("-view", "");
            const postId = view.querySelector(".my-post-card").dataset.id;
            handleDeletePost(postId, subTab);
        }
    });
}

async function handleDeletePost(postId, subTab) {
    const confirmed = await showConfirmationModal(
        "Delete Post?",
        "This action is permanent and will remove all associated requests.",
        "Delete",
        "bg-red-600",
    );

    if (confirmed) {
        try {
            const response = await fetch("/dashboard/post/delete", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                body: JSON.stringify({ id: postId, type: subTab }),
            });

            if (response.ok) {
                const view = document.getElementById(`posts-${subTab}-view`);
                view.dataset.viewState = "grid";

                renderMyPosts(subTab);
                notify("Post deleted", "success");
                refreshAfterAction();
            }
        } catch (error) {
            notify("Error deleting post", "error");
        }
    }
}

document.querySelectorAll(".back-to-grid-btn").forEach((btn) => {
    btn.addEventListener("click", () => {
        const view = btn.closest(".post-management-view");
        view.dataset.viewState = "grid";
        const subTab = view.id.replace("posts-", "").replace("-view", "");
        renderMyPosts(subTab);
    });
});

//==========================Helpers==================

async function refreshAfterAction() {
    updateStats();
    const activeTabBtn = document.querySelector(".tab-btn.active");
    if (!activeTabBtn) return;

    const activeTab = activeTabBtn.dataset.tab;
    const activeSubBtn = document.querySelector(
        `#${activeTab} .sub-tab-btn.active`,
    );
    if (!activeSubBtn) return;

    const activeSub = activeSubBtn.dataset.subtab;

    if (activeTab === "saved") renderSavedCards(activeSub);
    else if (activeTab === "my-requests") renderMyRequests(activeSub);
    else if (activeTab === "my-posts") renderMyPosts(activeSub);
}

async function updateStats() {
    try {
        const response = await fetch("/dashboard/stats");
        const stats = await response.json();

        document.getElementById("stat-saved-count").textContent = stats.saved;
        document.getElementById("stat-requests-count").textContent = stats.sent;
        document.getElementById("stat-incoming-count").textContent =
            stats.incoming;
        document.getElementById("stat-posts-count").textContent = stats.posts;
    } catch (error) {}
}

//=======================Tab Management==============================

function setupTabListeners() {
    document.querySelectorAll(".tab-btn").forEach((btn) => {
        btn.addEventListener("click", () => {
            document
                .querySelectorAll(".tab-btn")
                .forEach((b) => b.classList.remove("active"));
            document
                .querySelectorAll(".tab-content")
                .forEach((c) => c.classList.remove("active"));
            btn.classList.add("active");
            document.getElementById(btn.dataset.tab).classList.add("active");
            const firstSub = document.querySelector(
                `#${btn.dataset.tab} .sub-tab-btn`,
            );
            if (firstSub) firstSub.click();
        });
    });
    document.querySelectorAll(".sub-tab-btn").forEach((btn) => {
        btn.addEventListener("click", () => {
            const parent = btn.closest(".tab-content");
            parent
                .querySelectorAll(".sub-tab-btn")
                .forEach((b) => b.classList.remove("active"));
            parent
                .querySelectorAll(".sub-tab-content")
                .forEach((c) => c.classList.remove("active"));
            btn.classList.add("active");
            const tabId = parent.id;
            const subTab = btn.dataset.subtab;
            const targetId =
                tabId === "saved"
                    ? `saved-${subTab}`
                    : tabId === "my-requests"
                      ? `requests-${subTab}`
                      : `posts-${subTab}`;
            document.getElementById(targetId).classList.add("active");
            if (tabId === "saved") renderSavedCards(subTab);
            else if (tabId === "my-requests") renderMyRequests(subTab);
            else if (tabId === "my-posts") renderMyPosts(subTab);
        });
    });
}

//===================Modals===================================
function showConfirmationModal(
    title,
    message,
    confirmText = "Confirm",
    confirmClass = "bg-primary",
) {
    return new Promise((resolve) => {
        let modal = document.getElementById("confirmation-modal");
        if (!modal) {
            modal = document.createElement("div");
            modal.id = "confirmation-modal";
            modal.innerHTML = `<div class="modal-backdrop"><div class="modal-content"><div class="modal-icon"><i class="fas fa-exclamation-triangle"></i></div><h3 class="modal-title"></h3><p class="modal-message"></p><div class="modal-buttons"><button class="modal-btn cancel">Cancel</button><button class="modal-btn confirm"></button></div></div></div>`;
            document.body.appendChild(modal);
        }
        const backdrop = modal.querySelector(".modal-backdrop");
        modal.querySelector(".modal-title").textContent = title;
        modal.querySelector(".modal-message").textContent = message;
        const confirmBtn = modal.querySelector(".confirm");
        confirmBtn.textContent = confirmText;
        confirmBtn.className = `modal-btn confirm ${confirmClass}`;
        backdrop.style.display = "flex";
        setTimeout(() => backdrop.classList.add("visible"), 10);
        const cleanup = () => {
            backdrop.classList.remove("visible");
            setTimeout(() => (backdrop.style.display = "none"), 300);
        };
        confirmBtn.onclick = () => {
            cleanup();
            resolve(true);
        };
        modal.querySelector(".cancel").onclick = () => {
            cleanup();
            resolve(false);
        };
    });
}

function notify(message, type = "info") {
    const container = document.getElementById("notification-container");
    if (!container) return;
    const box = document.createElement("div");
    box.className = `notification-box notification-${type} show`;
    const icons = {
        success: "fas fa-check-circle",
        error: "fas fa-times-circle",
        info: "fas fa-info-circle",
    };
    box.innerHTML = `<i class="${icons[type]} notification-icon"></i><span class="notification-message">${message}</span>`;
    container.appendChild(box);
    setTimeout(() => {
        box.classList.remove("show");
        setTimeout(() => box.remove(), 500);
    }, 3500);
}

//===================Initialization===========================
document.addEventListener("DOMContentLoaded", async () => {
    setupTabListeners();
    setupSavedListeners();
    setupRequestsSentListeners();
    setupMyPostsListeners();

    updateStats();

    const defaultTab = document.querySelector('.tab-btn[data-tab="saved"]');
    if (defaultTab) defaultTab.click();
});
