<?php

namespace App\Http\Controllers;

use App\Models\chatParticipant;
use App\Http\Requests\StorechatParticipantRequest;
use App\Http\Requests\UpdatechatParticipantRequest;

class ChatParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorechatParticipantRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(chatParticipant $chatParticipant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(chatParticipant $chatParticipant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatechatParticipantRequest $request, chatParticipant $chatParticipant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(chatParticipant $chatParticipant)
    {
        //
    }
}
