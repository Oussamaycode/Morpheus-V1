<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\UpdateGameRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GameController extends Controller
{
    public function index()
{
    $user = auth()->user();

    return response()->json(
        $user->games()->get()
    );
}

    public function store(StoreGameRequest $request)
    {
        //
    }

    public function show(Game $game)
    {
        //
    }

    public function update(UpdateGameRequest $request, Game $game)
    {
        //
    }

    public function destroy(Game $game)
    {
        //
    }

    public function fetchGames($user)
  {


    if (!$user->steam_id) {
        return response()->json(['error' => 'Steam account not connected.'], 400);
    }

    $response = Http::withoutVerifying()
        ->get('https://api.steampowered.com/IPlayerService/GetOwnedGames/v1/', [
            'key'                       => env('STEAM_API_KEY'),
            'steamid'                   => $user->steam_id,
            'include_appinfo'           => true,
            'include_played_free_games' => true,
        ]);

    if (!$response->successful()) {
        return response()->json(['error' => 'Failed to fetch games.'], 500);
    }

    $games = $response->json('response.games');


    foreach ($games as $gameData) {
        // Create the game if it doesn't exist, or update it if it does
        $game = Game::create(
            [
                'name' => $gameData['name'],
                'image' => "https://cdn.cloudflare.steamstatic.com/steam/apps/{$gameData['appid']}/header.jpg",
            ]
        );

        // Attach the game to the user if not already attached
        $user->games()->attach($game->id);
    }

    return response()->json(['message' => 'Games synced successfully!', 'total' => count($games)]);
   }


}