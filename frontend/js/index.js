document.getElementById('connect-steam-btn').addEventListener('click', function() {
    const token = localStorage.getItem('token');
    window.location.href = `http://127.0.0.1:8000/api/auth/steam?token=${token}`;
});