<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Http\Requests\StoreSessionRequest;
use App\Http\Requests\UpdateSessionRequest;

class SessionController extends Controller
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
    public function store(StoreSessionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Session $session)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSessionRequest $request, Session $session)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Session $session)
    {
        //
    }

    public function startSession(Request $request)
    {
        $user = auth()->user();
        $game = $request->game;
        $hostIp = 'YOUR_HOST_IP';

        $response = Http::post("http://$hostIp:3000/start-game", [
            'user' => $user->email,
            'game' => $game
        ])->json();

        return response()->json([
            'guest_key' => $response['guest_key'],
            'message' => $response['message'],
            'host_ip' => $hostIp
        ]);
    }
}
