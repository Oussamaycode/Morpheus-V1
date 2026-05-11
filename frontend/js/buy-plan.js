
const API_URL = "http://127.0.0.1:8000/api";

document.addEventListener("DOMContentLoaded", loadPlans);

function loadPlans() {
  fetch(`${API_URL}/plans`)
    .then(res => res.json())
    .then(data => {
      renderPlans(data.plans);
    })
    .catch(err => console.error(err));
}

function selectPlan(planId) {
    const token = localStorage.getItem("token");

    fetch(`${API_URL}/plans/${planId}/checkout`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Authorization": `Bearer ${token}`
        },
    })
    .then(res => res.json())
    .then(data => {
       
        window.location.href = data.approval_url;
    })
    .catch(err => {
        console.error(err);
        alert(err.message);
    });
}

  

function renderPlans(plans) {
  const container = document.getElementById("plans-container");
  container.innerHTML = "";

  plans.forEach(plan => {
    container.innerHTML += `
      <div class="bg-surface rounded-lg p-6 border border-border">
        
        <div class="text-center mb-6">
          <h2 class="text-2xl font-bold mb-2">${plan.name}</h2>
          <div class="text-3xl font-bold text-primary mb-1">$${plan.price}</div>
          <div class="text-text-muted">per month</div>
        </div>

        <button 
          class="w-full bg-primary hover:bg-primary-hover text-white py-3 rounded transition-colors"
          onclick="selectPlan(${plan.id})">
          Upgrade to ${plan.name}
        </button>
      </div>
    `;
  });



}