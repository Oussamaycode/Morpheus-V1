<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Http\Requests\StoreTournamentRequest;
use App\Http\Requests\UpdateTournamentRequest;
use App\Controllers\TournamentParticipantController;

class TournamentController extends Controller
{
    /**
 * Display a listing of the resource.
     */
    public function index()
    {
        $tournaments=Tournament::all();
        return response()->json(["tournaments"=>$tournaments]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTournamentRequest $request)
    {
        $tournament=Tournament::create($request->validated());
        return response()->json($tournament);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tournament $tournament)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTournamentRequest $request, Tournament $tournament)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tournament $tournament)
    {
        //
    }

    public function join(Tournament $tournament)
    {
        $this->authorize('join',$tournament);

        $user = auth()->user();

        $tournament->users()->attach($user->id);
        
        return response()->json(['message' => 'Joined successfully!']);
    }

    public function start(Tournament $tournament){
        $this->authorize('start');

        $tournament->update(['status' => 'ongoing']);
    }

    public function end(Tournament $tournament)
    {
                
        if ($tournament->status !== 'ongoing') {
            return response()->json(['error' => 'Tournament is not ongoing.'], 400);
        }

        $participants = TournamentParticipant::where('tournament_id', $tournament->id)
            ->with('user')
            ->get();

        
        foreach ($participants as $participant) {
            $score = $this->getScore($participant->user->steam_id, $tournament->game->steam_app_id);
            $participant->update(['score' => $score]);
        }

        $sorted = TournamentParticipant::where('tournament_id', $tournament->id)
            ->orderBy('score', 'desc')
            ->get();

        $position = 1;

        foreach ($sorted as $participant) {
            $participant->update(['position' => $position]);
            $position++;
        }

        $tournament->update(['status' => 'finished']);

        return response()->json(['message' => 'Tournament finalized!']);
    }

     public function leaderboard(Tournament $tournament)
    {

       if($tournament->status=='finished'){
        $participants = TournamentParticipant::where('tournament_id', $tournament->id)
                ->with('user')
                ->orderBy('position')
                ->get();

            return response()->json($participants);
       }
    }

}
