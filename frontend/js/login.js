const API_URL = "http://127.0.0.1:8000/api";

document.getElementById("loginForm").addEventListener("submit", function(e) {
  e.preventDefault();

  const email = document.getElementById("email").value;
  const password = document.getElementById("password").value;

  fetch(`${API_URL}/login`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify({ email, password })
  })
  .then(async res => {
    const data = await res.json();
    if (!res.ok) throw data;
    return data;
  })
  .then(data => {
    localStorage.setItem("token", data.token);

    //document.getElementById("message").textContent = "Login successful!";

    window.location.href = "index.html";
  })
  .catch(err => {
    document.getElementById("message").textContent =
      err.message || "Invalid login";
  });
});