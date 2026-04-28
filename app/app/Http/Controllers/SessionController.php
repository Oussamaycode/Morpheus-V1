<?php

namespace App\Http\Controllers;

 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

    public function start()
    {
        
        $response = Http::withoutVerifying()->withToken(env('VASTAI_API_KEY'))
            ->get('https://console.vast.ai/api/v0/instances/');
 
        $instances = $response->json('instances') ?? [];
 
        // Find the one that is running
        $instance = collect($instances)->first(
            fn($i) => $i['actual_status'] === 'running'
        );
 
        if (!$instance) {
            return response()->json([
                'success' => false,
                'message' => 'No running instance found. Please start your instance from the Vast.ai dashboard.',
            ], 503);
        }
 
        $ip    = $instance['public_ipaddr'];
        $port  = $instance['ports']['6100/tcp'][0]['HostPort'];
        $session_token = $instance['jupyter_token'];
 
        return response()->json([
            'success'    => true,
            'stream_url' => "http://{$ip}:{$port}/?token={$session_token}",
        ]);
    }
}
