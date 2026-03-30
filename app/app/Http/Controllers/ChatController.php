<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Http\Requests\StoreChatRequest;
use App\Http\Requests\UpdateChatRequest;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $chat=Chat::with('messages')->findOrFail($id);
        return response()->json(['chat'=>$chat],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChatRequest $request)
    {
        $chat=Chat::create(['name'=>$request->name,'owner_id'=>auth()->user()->id]);
        $chat->users()->attach(auth()->user()->id());
        return response()->json(['chat'=>$chat],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChatRequest $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chat $chat)
    {
        //
    }

    public function addToChat(Chat $chat,User $user){
        $this->authorize('addTochat',[$chat,$user]);
        $chat->users()->attach($user->id);
        return response()->json(['message'=>'User added']);
    }

}
