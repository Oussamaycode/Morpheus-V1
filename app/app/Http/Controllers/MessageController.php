<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use App\Http\Models\Chat;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Chat $chat)
    {
        $messages=$chat->messages;
        return response()->json(["messages"=>$messages],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMessageRequest $request)
    {
        $message=Message::create($request->validated());
        return response()->json(['message'=>$message],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Chat $chat,Message $message)
    {
        $this->authorize('view',$chat);
        if($message->chat_id!==$chat->id){
            return response()->json(['error'=>'this message does not belong to this chat'],403);
        }
           
        return response()->json(['message'=>$message,'chat'=>$chat],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMessageRequest $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        //
    }


}
