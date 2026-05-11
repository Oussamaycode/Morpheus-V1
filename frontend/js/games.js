
const API_URL = "http://127.0.0.1:8000/api";
const token = localStorage.getItem("token");


document.addEventListener('DOMContentLoaded', () => {

    const grid = document.getElementById('games-grid');

    fetch(`${API_URL}/games`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
        }
    })
    .then(res => res.json())
    .then(games => {

        grid.innerHTML = '';

        if (!games.length) {
            grid.innerHTML = `
                <div class="text-text-muted col-span-full text-center">
                    No games found. Connect Steam first.
                </div>
            `;
            return;
        }

        games.forEach(game => {

            grid.innerHTML += `
                <div class="bg-surface rounded shadow-lg overflow-hidden">

                    <img src="${game.image}" class="w-full aspect-video object-cover">

                    <div class="p-4">
                        <div class="font-semibold mb-2 text-white">
                            ${game.name}
                        </div>

                        <button onclick="startGame(${game.id})"
                            class="w-full bg-primary text-white py-2 px-4 rounded">
                            Play
                        </button>
                    </div>

                </div>
            `;
        });

    });

});

async function startGame(gameId) {

    try {

        const token = localStorage.getItem('token');

        const response = await fetch('http://127.0.0.1:8000/api/start', {

            method: 'POST',

            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': `Bearer ${token}`
            },

            body: JSON.stringify({
                game_id: gameId
            })

        });

        const data = await response.json();

        console.log(data);

        // Redirect user to stream
        window.location.href = data.stream_url;

    } catch (error) {

        console.error(error);

    }

}