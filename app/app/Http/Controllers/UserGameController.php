<?php

namespace App\Http\Controllers;

use App\Models\userGame;
use App\Http\Requests\StoreuserGameRequest;
use App\Http\Requests\UpdateuserGameRequest;

class UserGameController extends Controller
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
    public function store(StoreuserGameRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(userGame $userGame)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateuserGameRequest $request, userGame $userGame)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(userGame $userGame)
    {
        //
    }
}
