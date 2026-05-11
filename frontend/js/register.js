const API_URL = "http://127.0.0.1:8000/api";

document.getElementById("registerForm").addEventListener("submit", function(e) {
  e.preventDefault();

  const name = document.getElementById("name").value;
  const email = document.getElementById("email").value;
  const password = document.getElementById("password").value;
  const password_confirmation = document.getElementById("password_confirmation").value;

  fetch(`${API_URL}/register`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify({
      name,
      email,
      password,
      password_confirmation
    })
  })
  .then(async res => {
    const data = await res.json();

    if (!res.ok) {
      throw data;
    }

    return data;
    
  })
  .then(data => {

    console.log(data);
    window.location.href = "index.html";
  })
  .catch(err => {
    document.getElementById("message").textContent =
      err.message || "Something went wrong";
    console.error(err);
  });
});