
const API_URL = "http://127.0.0.1:8000/api";

document.addEventListener("DOMContentLoaded", loadTournaments);



const token = localStorage.getItem("token");


function loadTournaments() {
  fetch(`${API_URL}/tournaments`,{
    method: 'GET',
    headers: {
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json'
    }
    })
    .then(res => res.json())
    .then(data => {
      renderTournaments(data.tournaments);
    })
    .catch(err => console.error(err));
}

function renderTournaments(tournaments) {
  const container = document.getElementById("tournaments-container");
  container.innerHTML = "";

  tournaments.forEach(tournament => {
    container.innerHTML += `
      <div class="bg-surface rounded-3xl border border-border p-6">
        <div class="flex items-center justify-between mb-4">
          <div>
            <h2 class="text-2xl font-semibold">${tournament.name}</h2>
            <p class="text-text-muted mt-1">${tournament.description}</p>
          </div>
          <button 
            class="bg-primary hover:bg-primary-hover text-white px-4 py-2 rounded transition-colors"
            onclick="joinTournament(${tournament.id}, '${tournament.name}')">
            Join
          </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-text-muted">
          <div><span class="font-semibold text-white">Entry Fee</span><br>${tournament.status}</div>
          <div><span class="font-semibold text-white">Start</span><br>${formatDate(tournament.start_time)}</div>
        </div>
      </div>
    `;
  });
}

function joinTournament(id, name) {
  const token = localStorage.getItem("token");

  fetch(`${API_URL}/tournaments/${id}/join`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "Authorization": `Bearer ${token}`
    }
  })
  .then(async res => {
    const data = await res.json();

    if (!res.ok) {
      throw new Error(data.message || "Error joining tournament");
    }

    return data;
  })
  .then(data => {
    alert(`You joined ${name}!`);
  })
  .catch(err => {
    console.error(err);
    alert(err.message);
  });
}


function formatDate(dateString) {
  const date = new Date(dateString);
  return date.toLocaleString();
}
