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
        $
        $ip    = $instance['public_ipaddr'];
        $port  = $instance['ports']['6100/tcp'][0]['HostPort'];
        $session_token = $instance['jupyter_token'];
 
        return response()->json([
            'stream_url' => "http://{$ip}:{$port}/?token={$session_token}",
        200]);
    }
}
