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
        //
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

    public function fetchGames(Request $request)
    {
        $user = $request->user();

        // Call the Steam API to get the user's games
        $response = Http::get('https://api.steampowered.com/IPlayerService/GetOwnedGames/v1/', [
            'key'                       => env('STEAM_API_KEY'),
            'steamid'                   => $user->steam_id,
            'include_appinfo'           => true,
            'include_played_free_games' => true,
        ]);

        $steamGames = $response->json('response.games');

        foreach ($steamGames as $steamGame) {

            // If the game doesn't exist in our database, create it
            $game = Game::firstOrCreate(
                ['app_id' => $steamGame['appid']],
                [
                    'name'        => $steamGame['name'],
                    'description' => '',
                    'image'       => "https://media.steampowered.com/steamcommunity/public/images/apps/{$steamGame['appid']}/{$steamGame['img_logo_url']}.jpg",
                ]
            );

            // Link the game to the user (only if not already linked)
            $user->games()->syncWithoutDetaching([$game->id]);
        }

        // Return the user's full game list
        $games = $user->games()->get();

        return response()->json([
            'total' => $games->count(),
            'games' => $games,
        ]);
    }
}