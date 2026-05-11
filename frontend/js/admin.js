const API_BASE = 'http://127.0.0.1:8000/api';

function getToken() {
  return localStorage.getItem('token');
}

function authHeaders() {
  return {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
    'Authorization': `Bearer ${getToken()}`,
  };
}


function toggleMenu() {
  document.getElementById('mobile-menu').classList.toggle('hidden');
}

function toggleTournamentForm() {
  document.getElementById('tournament-form').classList.toggle('hidden');
  document.getElementById('tournament-form-error').classList.add('hidden');
}


async function loadGames() {
  try {
    const res = await fetch(`${API_BASE}/games`, { headers: authHeaders() });
    if (!res.ok) return;

    const games = await res.json();
    const select = document.getElementById('tournament-game');

    games.forEach(game => {
      const opt = document.createElement('option');
      opt.value = game.id;
      opt.textContent = game.name;
      select.appendChild(opt);
    });
  } catch (e) {
    console.error('Could not load games:', e);
  }
}



async function loadTournaments() {
  const loading = document.getElementById('tournaments-loading');
  const errorEl = document.getElementById('tournaments-error');
  const wrapper = document.getElementById('tournaments-table-wrapper');
  const empty   = document.getElementById('tournaments-empty');
  const tbody   = document.getElementById('tournaments-tbody');

  // Reset state
  loading.classList.remove('hidden');
  errorEl.classList.add('hidden');
  wrapper.classList.add('hidden');
  empty.classList.add('hidden');

  try {
    const res = await fetch(`${API_BASE}/tournaments`, { headers: authHeaders() });
    if (!res.ok) throw new Error(`Server error: ${res.status}`);

    const data = await res.json();
    const tournaments = data.tournaments; // unwrap { "tournaments": [...] }

    loading.classList.add('hidden');

    if (!tournaments.length) {
      empty.classList.remove('hidden');
      return;
    }

    tbody.innerHTML = '';
    tournaments.forEach(renderTournamentRow);
    wrapper.classList.remove('hidden');

  } catch (e) {
    loading.classList.add('hidden');
    errorEl.textContent = e.message || 'Could not load tournaments.';
    errorEl.classList.remove('hidden');
  }
}

function renderTournamentRow(t) {
  const tbody = document.getElementById('tournaments-tbody');

  const statusColor =
    t.status === 'ongoing' ? 'bg-green-700 text-white' :
    t.status === 'ended'   ? 'bg-red-900 text-white'   :
                             'bg-accent text-text-muted';

  const statusLabel = t.status
    ? t.status.charAt(0).toUpperCase() + t.status.slice(1)
    : 'Pending';

  const startDisabled = t.status === 'ongoing' || t.status === 'ended' ? 'disabled' : '';
  const endDisabled   = t.status !== 'ongoing' ? 'disabled' : '';

  const row = document.createElement('tr');
  row.className = 'border-b border-accent';
  row.id = `tournament-row-${t.id}`;
  row.innerHTML = `
    <td class="p-4">${t.id}</td>
    <td class="p-4">${t.name}</td>
    <td class="p-4">${t.start_date ?? '—'}</td>
    <td class="p-4">
      <span class="inline-block px-3 py-1 rounded text-sm font-semibold ${statusColor}">
        ${statusLabel}
      </span>
    </td>
    <td class="p-4">
      <div class="flex gap-2">
        <button
          id="start-btn-${t.id}"
          onclick="tournamentAction(${t.id}, 'start')"
          ${startDisabled}
          class="bg-primary hover:bg-primary-hover disabled:opacity-40 disabled:cursor-not-allowed text-white py-1 px-3 rounded text-sm transition-colors">
          Start
        </button>
        <button
          id="end-btn-${t.id}"
          onclick="tournamentAction(${t.id}, 'end')"
          ${endDisabled}
          class="bg-red-600 hover:bg-red-700 disabled:opacity-40 disabled:cursor-not-allowed text-white py-1 px-3 rounded text-sm transition-colors">
          End
        </button>
      </div>
    </td>
  `;

  tbody.appendChild(row);
}



async function tournamentAction(id, action) {
  const btn = document.getElementById(`${action}-btn-${id}`);
  const originalText = btn.textContent.trim();
  btn.disabled = true;
  btn.textContent = action === 'start' ? 'Starting…' : 'Ending…';

  try {
    const res = await fetch(`${API_BASE}/tournaments/${id}/${action}`, {
      method: 'POST',
      headers: authHeaders(),
    });

    if (!res.ok) {
      const data = await res.json().catch(() => ({}));
      throw new Error(data.message || `Failed to ${action} tournament.`);
    }

    await loadTournaments(); // refresh the table
  } catch (e) {
    alert(e.message);
    btn.disabled = false;
    btn.textContent = originalText;
  }
}



async function createAdminTournament(event) {
  event.preventDefault();

  const errorEl   = document.getElementById('tournament-form-error');
  const submitBtn = document.getElementById('tournament-submit-btn');
  errorEl.classList.add('hidden');
  submitBtn.disabled = true;
  submitBtn.textContent = 'Saving…';

  const payload = {
    name:       document.getElementById('tournament-name').value.trim(),
    game_id:    document.getElementById('tournament-game').value,
    start_date: document.getElementById('tournament-start').value,
  };

  try {
    const res = await fetch(`${API_BASE}/tournaments`, {
      method: 'POST',
      headers: authHeaders(),
      body: JSON.stringify(payload),
    });

    const data = await res.json();

    if (!res.ok) {
      const message = data.errors
        ? Object.values(data.errors).flat().join(' ')
        : data.message || 'Failed to create tournament.';
      throw new Error(message);
    }

    document.getElementById('tournament-form').reset();
    document.getElementById('tournament-form').classList.add('hidden');
    await loadTournaments();

  } catch (e) {
    errorEl.textContent = e.message;
    errorEl.classList.remove('hidden');
  } finally {
    submitBtn.disabled = false;
    submitBtn.textContent = 'Save Tournament';
  }
}



async function loadUsers() {
  const loading = document.getElementById('users-loading');
  const errorEl = document.getElementById('users-error');
  const wrapper = document.getElementById('users-table-wrapper');
  const empty   = document.getElementById('users-empty');
  const tbody   = document.getElementById('users-tbody');

  loading.classList.remove('hidden');
  errorEl.classList.add('hidden');
  wrapper.classList.add('hidden');
  empty.classList.add('hidden');

  try {
    const res = await fetch(`${API_BASE}/users`, { headers: authHeaders() });
    if (!res.ok) throw new Error(`Server error: ${res.status}`);

    const data  = await res.json();
    const users = data.users; // unwrap { "users": [...] }

    loading.classList.add('hidden');

    if (!users.length) {
      empty.classList.remove('hidden');
      return;
    }

    tbody.innerHTML = '';
    users.forEach(renderUserRow);
    wrapper.classList.remove('hidden');

  } catch (e) {
    loading.classList.add('hidden');
    errorEl.textContent = e.message || 'Could not load users.';
    errorEl.classList.remove('hidden');
  }
}

function renderUserRow(u) {
  const tbody = document.getElementById('users-tbody');

  const isBanned     = u.banned_at !== null && u.banned_at !== undefined;
  const banLabel     = isBanned ? 'Unban' : 'Ban';
  const banClass     = isBanned
    ? 'bg-surface border border-border hover:bg-accent'
    : 'bg-red-600 hover:bg-red-700';

  const row = document.createElement('tr');
  row.className = 'border-b border-accent';
  row.id = `user-row-${u.id}`;
  row.innerHTML = `
    <td class="p-4">${u.id}</td>
    <td class="p-4">${u.name}</td>
    <td class="p-4">${u.email}</td>
    <td class="p-4">
      <span class="inline-block px-3 py-1 rounded text-sm font-semibold ${isBanned ? 'bg-red-900 text-white' : 'bg-accent text-text-muted'}">
        ${isBanned ? 'Banned' : 'Active'}
      </span>
    </td>
    <td class="p-4">
      <button
        id="ban-btn-${u.id}"
        onclick="banUser(${u.id})"
        class="${banClass} text-white py-1 px-3 rounded text-sm transition-colors">
        ${banLabel}
      </button>
    </td>
  `;

  tbody.appendChild(row);
}

// ── Ban / Unban User ──────────────────────────────────────────────────────────

async function banUser(id) {
  const btn = document.getElementById(`ban-btn-${id}`);
  const originalText = btn.textContent.trim();
  btn.disabled = true;
  btn.textContent = 'Loading…';

  try {
    const res = await fetch(`${API_BASE}/users/${id}/ban`, {
      method: 'POST',
      headers: authHeaders(),
    });

    if (!res.ok) {
      const data = await res.json().catch(() => ({}));
      throw new Error(data.message || 'Failed to update user.');
    }

    await loadUsers(); // refresh the table
  } catch (e) {
    alert(e.message);
    btn.disabled = false;
    btn.textContent = originalText;
  }
}

document.addEventListener('DOMContentLoaded', () => {
  loadGames();
  loadTournaments();
  loadUsers();
  loadSessions();
});



async function loadSessions() {
  const loading = document.getElementById('sessions-loading');
  const errorEl = document.getElementById('sessions-error');
  const wrapper = document.getElementById('sessions-table-wrapper');
  const empty   = document.getElementById('sessions-empty');
  const tbody   = document.getElementById('sessions-tbody');

  loading.classList.remove('hidden');
  errorEl.classList.add('hidden');
  wrapper.classList.add('hidden');
  empty.classList.add('hidden');

  try {
    const res = await fetch(`${API_BASE}/sessions`, { headers: authHeaders() });
    if (!res.ok) throw new Error(`Server error: ${res.status}`);

    const data     = await res.json();
    const sessions = data.gameSessions; // unwrap { "gameSessions": [...] }

    loading.classList.add('hidden');

    if (!sessions.length) {
      empty.classList.remove('hidden');
      return;
    }

    tbody.innerHTML = '';
    sessions.forEach(renderSessionRow);
    wrapper.classList.remove('hidden');

  } catch (e) {
    loading.classList.add('hidden');
    errorEl.textContent = e.message || 'Could not load sessions.';
    errorEl.classList.remove('hidden');
  }
}

function renderSessionRow(s) {
  const tbody = document.getElementById('sessions-tbody');

  const row = document.createElement('tr');
  row.className = 'border-b border-accent';
  row.innerHTML = `
    <td class="p-4">${s.id}</td>
    <td class="p-4">${s.user_id ?? '—'}</td>
    <td class="p-4">${s.game_id ?? '—'}</td>
    <td class="p-4">${s.created_at ?? '—'}</td>
    <td class="p-4">${s.status ?? '—'}</td>
  `;

  tbody.appendChild(row);
}