<?php

namespace App\Http\Controllers;

use App\Models\TournamentParticipant;
use App\Http\Requests\StoreTournamentParticipantRequest;
use App\Http\Requests\UpdateTournamentParticipantRequest;

class TournamentParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTournamentParticipantRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TournamentParticipant $tournamentParticipant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTournamentParticipantRequest $request, TournamentParticipant $tournamentParticipant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TournamentParticipant $tournamentParticipant)
    {
        //
    }

    public function getScore(TournamentParticipant $tournamentParticipant)
    {
        $response = Http::get('https://api.steampowered.com/ISteamUserStats/GetUserStatsForGame/v2/', [
            'key'     => config('services.steam.api_key'),
            'steamid' => $steamId,
            'appid'   => $appId,
            ]);

        if (!$response->successful()) {
            return 0; 
        }

        $stats = $response->json('playerstats.stats');

        $scoreStat = collect($stats)->firstWhere('name', 'total_kills'); // change this to match the game's stat name

        return $scoreStat['value'] ?? 0;
    }
}
