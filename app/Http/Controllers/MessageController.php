<?php

namespace App\Http\Controllers;

use App\Events\MessageEvent;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {


        return view('chat');
    }

    public function FetchMessage()
    {
        return Message::with('user')->get();
    }

    public function StoreMessage(Request $request)
    {

        $message = auth()->user()->messages()->create([
            'message' => $request->message,
        ]);

        broadcast(new MessageEvent($message->load('user')))->toOthers();

        return response()->json([
            'status' => 'message send',
        ]);
    }
}
