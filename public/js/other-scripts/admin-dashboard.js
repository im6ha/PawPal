


import {showNotification} from '../components/modal.js';


import {
  createPetCard,
  createProductCard,
  createLostFoundCard,
  createServiceCard
} from '../components/cards.js';

function createAdminPostCard(item, type, context) {
  if (!item || !item.user) return null;
  let card;
  
  if (type === 'adoption') {

    card = createPetCard({
  id: item.id,
  user_id: item.user_id,
  imageUrl: item.image_path,
  type: item.pet_type,
  description: item.description,
  location: item.wilaya_name || 'Unknown',
  gender: item.gender
});
  } else if (type === 'products') {
    card = createProductCard(item);
  } else if (type === 'sitters') {
    card = createServiceCard({
  id: item.id,
  user_id: item.user_id,
  name: item.user.name,
  location: item.wilaya_name || 'Unknown',
  description: item.bio,
  fee: item.fee_per_day,
  avatarUrl: item.profile_image_path
});
  } else if (type === 'lost-pets') {
    card = createLostFoundCard({
  id: item.id,
  user_id: item.user_id,
  imageUrl: item.image_path,
  type: item.pet_type,
  description: item.description,
  location: item.wilaya_name || 'Unknown',
  lastSeen: item.last_seen_area,
  status: item.post_type
});
  }
  
  if (!card) return null;

  const userActions = card.querySelector('.card-actions');
  if (userActions) userActions.remove();
  
  const adminInfo = document.createElement('div');
  adminInfo.className = 'card-admin-info';
  adminInfo.innerHTML = `
    <div class="poster-details">
      <div class="poster-info">
        <span class="poster-name">${item.user.name}</span>
        <span class="poster-id">User ID: ${item.user_id}</span>
      </div>
      <div class="post-date">Posted: ${formatDate(item.created_at)}</div>
    </div>
  `;
  
  const adminActions = document.createElement('div');
  adminActions.className = 'card-admin-actions';
  
  if (context === 'accepted') {
    adminActions.innerHTML = `
      <button class="admin-btn btn-reject" data-id="${item.id}" data-action="delete" data-type="${type}">
        <i class="fas fa-trash"></i> Delete Post
      </button>
    `;
  } else {
    adminActions.innerHTML = `
      <button class="admin-btn btn-approve" data-id="${item.id}" data-action="approve" data-type="${type}">
        <i class="fas fa-check"></i> Approve
      </button>
      <button class="admin-btn btn-reject" data-id="${item.id}" data-action="reject" data-type="${type}">
        <i class="fas fa-times"></i> Reject
      </button>
    `;
  }
  
  card.appendChild(adminInfo);
  card.appendChild(adminActions);
  
  return card;
}




async function renderPosts(context, type) {
  const gridId = `${context}-${type}-grid`;
  const grid = document.getElementById(gridId);
  if (!grid) return;

  grid.innerHTML = '<div class="loading">Loading posts...</div>';

  try {
    const status = context === 'requested' ? 'pending' : 'accepted';
    
    const response = await fetch(`/admin/posts/${type}/${status}`);
    const result = await response.json();

    grid.innerHTML = '';

    if (!result.data || result.data.length === 0) {
      grid.appendChild(createEmptyState(
        'fas fa-inbox',
        `No ${context} ${type} found`,
        'All items in this category have been processed'
      ));
      return;
    }

    result.data.forEach(item => {
      const card = createAdminPostCard(item, type, context);
      if (card) {
        card.querySelectorAll('.admin-btn').forEach(btn => {
          btn.addEventListener('click', handleAdminAction);
        });
        grid.appendChild(card);
      }
    });
  } catch (error) {
    grid.innerHTML = '<div class="error">Failed to load data from server.</div>';
    console.error('Error fetching posts:', error);
  }
}


async function handleAdminAction(e) {
  const btn = e.target.closest('.admin-btn');
  const { action, id, type } = btn.dataset;
  
  let title, message, isDestructive = false;

  if (action === 'approve') {
    title = "Approve Post";
    message = `Are you sure you want to approve post #${id}?`;
  } else {
    title = action === 'reject' ? "Reject Post" : "Delete Post";
    message = `Are you sure you want to ${action} post #${id}? This action cannot be undone.`;
    isDestructive = true;
  }

  if (await showActionModal(title, message, isDestructive)) {
    try {
      const response = await fetch(`/admin/posts/${type}/${id}/action`, {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'Accept': 'application/json' 
  },
  body: JSON.stringify({ action })
});

      if (response.ok) {
        showNotification('success', `Post ${action}ed successfully`);
        refreshAfterAction('success', 'post');
      } else {
        showNotification('error', 'Action failed');
      }
    } catch (error) {
      console.error('Error updating post:', error);
      showNotification('error', 'Server error');
    }
  }
}











//=======================Reports===================

function createReportItem(report, type) {
  if (!report.reportable) return document.createElement('div');
  const reportItem = document.createElement('div');
  reportItem.className = 'report-item';

  const post = report.reportable;
  const poster = post.user;

  reportItem.innerHTML = `
    <div class="report-header">
      <div class="report-title">Report #${report.id} | Against User: ${poster.name} (ID: ${poster.id})</div>
      <div class="report-date">${formatDate(report.created_at)}</div>
    </div>

    <div class="report-content">
      <p><strong>Status:</strong> ${report.status}</p>
      
      <button class="btn-secondary toggle-post-btn">
        <i class="fas fa-eye"></i> View Reported Post
      </button>

      <div class="reported-post-preview" style="display: none; margin-top: 15px;">
        <div class="preview-container"></div>
      </div>
    </div>

    <div class="report-actions" style="margin-top: 15px;">
      <button class="btn-action btn-resolve" data-id="${report.id}" data-user-id="${poster.id}" data-action="resolve">
        <i class="fas fa-check-circle"></i> Resolve (Trust -1)
      </button>
      <button class="btn-action btn-delete-post" data-id="${report.id}" data-user-id="${poster.id}" data-action="delete_post">
        <i class="fas fa-file-excel"></i> Delete Post (Trust 0)
      </button>
      <button class="btn-action btn-delete-report" data-id="${report.id}" data-user-id="${poster.id}" data-action="delete_report">
        <i class="fas fa-trash"></i> Delete Report
      </button>
      <button class="btn-action btn-ban" data-id="${report.id}" data-user-id="${poster.id}" data-action="ban">
        <i class="fas fa-user-slash"></i> Ban User
      </button>
    </div>
  `;

  const previewContainer = reportItem.querySelector('.preview-container');
  let postCard;

  if (type === 'adoption') {
postCard = createPetCard({
  id: post.id,
  user_id: post.user_id,
  imageUrl: post.image_path,
  type: post.pet_type,
  description: post.description,
  location: post.wilaya_name || 'Unknown',
  gender: post.gender
});  } else if (type === 'products') {
    postCard = createProductCard(post);
  } else if (type === 'sitters') {
postCard = createServiceCard({
  id: post.id,
  user_id: post.user_id,
  name: poster.name,
  location: post.wilaya_name || 'Unknown',
  description: post.bio,
  fee: post.fee_per_day,
  avatarUrl: post.profile_image_path
});  } else if (type === 'lost-pets') {
postCard = createLostFoundCard({
  id: post.id,
  user_id: post.user_id,
  imageUrl: post.image_path,
  type: post.pet_type,
  description: post.description,
  location: post.wilaya_name || 'Unknown',
  lastSeen: post.last_seen_area,
  status: post.post_type
});  }

  if (postCard) {
    postCard.style.width = 'fit-content';
    postCard.style.margin = '0 auto';
    const actions = postCard.querySelector('.card-actions');
    if (actions) actions.remove();
    previewContainer.appendChild(postCard);
  }

  reportItem.querySelector('.toggle-post-btn').addEventListener('click', () => {
    const preview = reportItem.querySelector('.reported-post-preview');
    preview.style.display = preview.style.display === 'none' ? 'block' : 'none';
  });

  return reportItem;
}



async function renderReports(type) {
  const listId = `reports-${type}-list`;
  const list = document.getElementById(listId);
  if (!list) return;

  list.innerHTML = '<div class="loading">Loading reports...</div>';

  try {
    const response = await fetch(`/admin/reports/${type}`);
    const result = await response.json();
    const reports = result.data;

    list.innerHTML = ''; 

    if (!reports || reports.length === 0) {
      list.appendChild(createEmptyState('fas fa-check-circle', 'No reports found', `All ${type} reports are resolved.`));
      return;
    }

    reports.forEach(report => {
      if (!report.reportable) return; 
      
      const reportItem = createReportItem(report, type);
      
      reportItem.querySelectorAll('.btn-action').forEach(btn => {
        btn.addEventListener('click', handleReportAction);
      });
      
      list.appendChild(reportItem);
    });
  } catch (error) {
    console.error('Fetch error:', error);
    list.innerHTML = '<div class="error">Failed to load reports.</div>';
  }
}



async function handleReportAction(e) {
  const btn = e.target.closest('.btn-action');
  const { action, id, userId } = btn.dataset; 
  
  let title, message, isDestructive = false;

  switch (action) {
    case 'resolve':
      title = "Resolve Report";
      message = "Mark this as resolved? The user's trust score will decrease by 1.";
      break;
    case 'delete_post':
      title = "Delete Reported Post";
      message = "Delete the post entirely? The user's trust score will be reset to 0. This cannot be undone.";
      isDestructive = true;
      break;
    case 'delete_report':
      title = "Dismiss Report";
      message = "Remove this report without penalizing the user?";
      isDestructive = true;
      break;
    case 'ban':
      title = "Ban User";
      message = "Permanently ban this user? They will no longer be able to access the platform.";
      isDestructive = true;
      break;
  }

  if (await showActionModal(title, message, isDestructive)) {
    try {
      const response = await fetch(`/admin/reports/${id}/action`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          'Accept': 'application/json'
        },
        body: JSON.stringify({ 
          action,
          user_id: userId 
        })
      });

      const result = await response.json();

      if (response.ok) {
        showNotification('success', result.message);
        refreshAfterAction('success', 'report');
      } else {
        showNotification('error', result.error || 'Action failed');
      }
    } catch (error) {
      console.error('Report Action Error:', error);
      showNotification('error', 'Server error occurred');
    }
  }
}









//=======================Users==============================


function createUserCard(user) {
  const userCard = document.createElement('div');
  userCard.className = 'user-card';
  
  let trustClass = 'trust-4';
  if (user.trust_score >= 8) trustClass = 'trust-10';
  else if (user.trust_score >= 5) trustClass = 'trust-8';
  
  userCard.innerHTML = `
    <div class="user-header">
      <img src="${user.profile_image || '/media/images/avatar-default.png'}" alt="${user.name}" class="user-avatar">
      <div class="user-info">
        <div class="user-name">${user.name}</div>
        <div class="user-id">ID: ${user.id}</div>
        <div class="user-email" style="font-size: 0.8rem; color: #64748b;">${user.email}</div>
      </div>
    </div>
    <div class="trust-meter">
      <span class="trust-label">Trust Score:</span>
      <span class="trust-score">${user.trust_score}/10</span>
      <div class="trust-bar">
        <div class="trust-fill ${trustClass}" style="width: ${user.trust_score * 10}%"></div>
      </div>
    </div>
    <div class="user-stats">
      <div class="stat-item">
        <div class="stat-value">${user.status === 'active' ? 'Active' : 'Banned'}</div>
        <div class="stat-label">Status</div>
      </div>
      <div class="stat-item">
        <div class="stat-value">${formatDate(user.created_at)}</div>
        <div class="stat-label">Member Since</div>
      </div>
    </div>
    <div class="user-actions">
      <button class="btn-action ${user.status === 'active' ? 'btn-delete' : 'btn-approve'}" data-id="${user.id}" data-action="${user.status === 'active' ? 'ban' : 'unban'}">
        <i class="fas fa-${user.status === 'active' ? 'user-lock' : 'user-check'}"></i> ${user.status === 'active' ? 'Ban' : 'Unban'}
      </button>
    </div>
  `;
  
  return userCard;
}




async function renderUsers() {
  const grid = document.getElementById('users-grid');
  if (!grid) return;

  grid.innerHTML = '<div class="loading">Loading users...</div>';

  try {
    const response = await fetch('/admin/users');
    const result = await response.json();
    
    window.allUsers = result.data || []; 
    
    displayUsers(window.allUsers);
  } catch (error) {
    grid.innerHTML = '<div class="error">Failed to load users.</div>';
    console.error('Error fetching users:', error);
  }
}

function displayUsers(userList) {
  const grid = document.getElementById('users-grid');
  grid.innerHTML = '';

  if (userList.length === 0) {
    grid.appendChild(createEmptyState('fas fa-user-slash', 'No users found', 'Try adjusting your filters.'));
    return;
  }

  userList.forEach(user => {
    const card = createUserCard(user);
    card.querySelectorAll('.btn-action').forEach(btn => {
      btn.addEventListener('click', handleUserAction);
    });
    grid.appendChild(card);
  });
}

function filterUsers(searchTerm) {
  if (!window.allUsers) return;
  
  const filtered = window.allUsers.filter(user => 
    user.name.toLowerCase().includes(searchTerm) || 
    user.id.toString().includes(searchTerm) ||
    user.email.toLowerCase().includes(searchTerm)
  );
  displayUsers(filtered);
}

function filterUsersByTrustLevel(filterValue) {
  if (!window.allUsers) return;
  
  let filtered;
  switch (filterValue) {
    case 'trusted':
      filtered = window.allUsers.filter(user => user.trust_score >= 8);
      break;
    case 'normal':
      filtered = window.allUsers.filter(user => user.trust_score >= 5 && user.trust_score <= 7);
      break;
    case 'suspicious':
      filtered = window.allUsers.filter(user => user.trust_score <= 4);
      break;
    case 'banned':
      filtered = window.allUsers.filter(user => user.status === 'banned');
      break;
    default:
      filtered = [...window.allUsers];
  }
  displayUsers(filtered);
}


async function handleUserAction(e) {
  const btn = e.target.closest('.btn-action');
  const { action, id } = btn.dataset;
  
  if (action === 'view') {
    window.location.href = `/profile/${id}`;
    return;
  }

  const title = action === 'ban' ? "Ban User" : "Unban User";
  const message = `Are you sure you want to ${action} user #${id}?`;
  const isDestructive = action === 'ban';

  if (await showActionModal(title, message, isDestructive)) {
    try {
      const response = await fetch(`/admin/users/${id}/status`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          'Accept': 'application/json'
        },
        body: JSON.stringify({ status: action === 'ban' ? 'banned' : 'active' })
      });

      if (response.ok) {
        showNotification('success', `User ${action}ed successfully`);
        renderUsers(); 
      } else {
        showNotification('error', 'Action failed');
      }
    } catch (error) {
      console.error('User action error:', error);
      showNotification('error', 'Server error');
    }
  }
}


//=====================================================
function createEmptyState(icon, title, message) {
  const emptyState = document.createElement('div');
  emptyState.className = 'empty-state';
  emptyState.innerHTML = `
    <div class="empty-state-icon">
      <i class="${icon}"></i>
    </div>
    <h3>${title}</h3>
    <p>${message}</p>
  `;
  return emptyState;
}

//=================================================================












// =======================================================================================================



function showActionModal(title, message, isDestructive = false) {
  const modal = document.getElementById('action-modal');
  const modalTitle = document.getElementById('modal-title');
  const modalMessage = document.getElementById('modal-message');
  const confirmBtn = document.getElementById('confirm-btn');
  const cancelBtns = modal.querySelectorAll('.cancel-btn, .close-modal');

  modalTitle.textContent = title;
  modalMessage.textContent = message;
  
  confirmBtn.classList.toggle('btn-cancel', isDestructive);
  confirmBtn.classList.toggle('btn-confirm', !isDestructive);
  
  modal.style.display = 'block';

  return new Promise((resolve) => {
    confirmBtn.onclick = () => {
      modal.style.display = 'none';
      resolve(true);
    };

    const handleCancel = () => {
      modal.style.display = 'none';
      resolve(false);
    };

    cancelBtns.forEach(btn => btn.onclick = handleCancel);
    window.onclick = (e) => { if (e.target === modal) handleCancel(); };
  });
}
function refreshAfterAction(status, entityType) {
  if (status !== 'success') return;
  updateStats();
  if (entityType === 'post') {
    const activeSubTab = document.querySelector('.sub-tab-content.active');
    if (activeSubTab) {
      const activeTypeBtn = activeSubTab.querySelector('.post-type-btn.active');
      if (activeTypeBtn) {
        activeTypeBtn.click();
      }
    }
  } else if (entityType === 'report') {
    const activeReportBtn = document.querySelector('.report-type-btn.active');
    if (activeReportBtn) {
      activeReportBtn.click();
    }
  } else if (entityType === 'user') {
    renderUsers();
  }
}


//=======================Stats==============================
async function updateStats() {
    try {
        const response = await fetch('/admin/stats');
        const stats = await response.json();

        document.getElementById('total-posts-count').textContent = stats.total_posts;
        document.getElementById('active-reports-count').textContent = stats.active_reports;
        document.getElementById('active-users-count').textContent = stats.active_users;
    } catch (error) {
        console.error('Error fetching stats:', error);
    }
}



//==============================================================


function setupTabNavigation() {
  document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const tabId = btn.dataset.tab;
      
      document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      
      document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.remove('active');
      });
      document.getElementById(tabId)?.classList.add('active');
      
      initializeTabContent(tabId);
    });
  });
  
  document.addEventListener('click', (e) => {
    if (e.target.classList.contains('sub-tab-btn')) {
      const btn = e.target;
      const subTabId = btn.dataset.subtab;
      
      const postsTab = document.getElementById('posts');
      if (!postsTab?.classList.contains('active')) return;
      
      postsTab.querySelectorAll('.sub-tab-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      
      document.querySelectorAll('#posts .sub-tab-content').forEach(content => {
        content.classList.remove('active');
      });
      
      document.getElementById(`${subTabId}-posts`)?.classList.add('active');
      
      const firstTypeBtn = document.querySelector(`#${subTabId}-posts .post-type-btn`);
      if (firstTypeBtn) {
        firstTypeBtn.click();
      }
    }
  });
  
  document.addEventListener('click', (e) => {
    if (e.target.classList.contains('post-type-btn')) {
      const btn = e.target;
      const parentTab = btn.closest('.sub-tab-content');
      const type = btn.dataset.type;
      
      parentTab.querySelectorAll('.post-type-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      
      parentTab.querySelectorAll('.post-type-content').forEach(content => {
        content.classList.remove('active');
      });
      
      const parentContext = parentTab.id.includes('accepted') ? 'accepted' : 'requested';
      const contentId = `${parentContext}-${type}`;
      document.getElementById(contentId)?.classList.add('active');
      
      renderPosts(parentContext, type);
    }
  });
  
  document.addEventListener('click', (e) => {
    if (e.target.classList.contains('report-type-btn')) {
      const btn = e.target;
      const type = btn.dataset.type;
      
      document.querySelectorAll('.report-type-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      
      document.querySelectorAll('.report-type-content').forEach(content => {
        content.classList.remove('active');
      });
      
      const contentId = `reports-${type}`;
      document.getElementById(contentId)?.classList.add('active');
      
      renderReports(type);
    }
  });
}


function initializeTabContent(tabId) {
  switch (tabId) {
    case 'posts':
      const acceptedBtn = document.querySelector('#posts .sub-tab-btn[data-subtab="accepted"]');
      if (acceptedBtn) acceptedBtn.click();
      break;
    case 'reports':
      const adoptionReportBtn = document.querySelector('.report-type-btn[data-type="adoption"]');
      if (adoptionReportBtn) adoptionReportBtn.click();
      break;
    case 'users':
      renderUsers();
      break;
  }
}

//===========================================================


function formatDate(dateString) {
  if (!dateString) return 'N/A';
  const options = { year: 'numeric', month: 'short', day: 'numeric' };
  return new Date(dateString).toLocaleDateString('en-US', options);
}

//==============================================================


function initializeAdminDashboard() {
  
  setupTabNavigation();
  updateStats();
  
  const userSearch = document.getElementById('user-search');
  const userFilter = document.getElementById('user-filter');
  
  if (userSearch) {
    userSearch.addEventListener('input', (e) => {
      filterUsers(e.target.value.toLowerCase());
    });
  }
  
  if (userFilter) {
    userFilter.addEventListener('change', (e) => {
      filterUsersByTrustLevel(e.target.value);
    });
  }
  
  const modal = document.getElementById('action-modal');
  const closeBtn = document.querySelector('.close');
  const cancelBtn = document.getElementById('cancel-btn');
  
  if (closeBtn) {
    closeBtn.onclick = () => modal.style.display = 'none';
  }
  
  if (cancelBtn) {
    cancelBtn.onclick = () => modal.style.display = 'none';
  }
  
  if (modal) {
    window.onclick = (event) => {
      if (event.target === modal) {
        modal.style.display = 'none';
      }
    };
  }
  
  const postsTabBtn = document.querySelector('.tab-btn[data-tab="posts"]');
  if (postsTabBtn) {
    postsTabBtn.click();
  }
}

document.addEventListener('DOMContentLoaded', initializeAdminDashboard);