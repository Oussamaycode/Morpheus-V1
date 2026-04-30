<?php

namespace App\Http\Controllers;

 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\StoreGameSessionRequest;
use App\Models\gameSession;

class gameSessionController extends Controller
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

    /**
     * Display the specified resource.
     */
    public function show(gameSession $session)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGameSessionRequest $request, Session $session)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(gameSession $session)
    {
        //
    }

    public function store(StoreGameSessionRequest $request)
    {
        $user=auth()->user();
        
        $response = Http::withoutVerifying()->withToken(env('VASTAI_API_KEY'))
            ->get("https://console.vast.ai/api/v0/instances/{$user->virtualMachine->vast_instance_id}");
 
        $instance = $response->json('instances');

 
        $ip    = $instance['public_ipaddr'];
        $port  = $instance['ports']['6100/tcp'][0]['HostPort'];
        $session_token = $instance['jupyter_token'];

        $session = gameSession::create([
            'stream_url' => "http://{$ip}:{$port}/?token={$session_token}",
            'game_id'=>$request->game_id,
            'user_id'=>$user->id,
        ]);
 
        return response()->json([
            'stream_url' => "http://{$ip}:{$port}/?token={$session_token}",200
        ]);
    }
}
