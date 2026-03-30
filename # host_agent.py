from flask import Flask, request
import subprocess
import json
import uuid

app = Flask(__name__)

# Keep track of approved sessions
active_sessions = {}

@app.route("/start-game", methods=["POST"])
def start_game():
    data = request.json
    username = data.get("user")
    game = data.get("game")

    # generate a unique guest key
    guest_key = str(uuid.uuid4())

    # launch the game
    if game == "csgo":
        subprocess.Popen([
            r"C:\Program Files (x86)\Steam\steam.exe", "-applaunch", "730"
        ])
    elif game == "gta5":
        subprocess.Popen([r"C:\Program Files\Rockstar Games\GTA V\GTA5.exe"])

    # store session info
    active_sessions[guest_key] = {
        "user": username,
        "game": game
    }

    return {"status": "ok", "guest_key": guest_key, "message": f"{game} started for {username}"}

app.run(host="0.0.0.0", port=3000)