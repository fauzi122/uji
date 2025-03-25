<?php

namespace App\Http\Controllers\mhs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PrivateMessage;
use App\Events\PrivateMessageSent;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class PrivateChatController extends Controller
{
    public function sendPrivateMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string'
        ]);

        $senderId = Auth::id();
        $receiverId = $request->receiver_id;

        // Ambil pesan terakhir user
        $lastMessage = PrivateMessage::where('sender_id', $senderId)
            ->orderByDesc('created_at')
            ->first();

        if ($lastMessage && $lastMessage->created_at->diffInSeconds(now()) < 10) {
            return response()->json([
                'error' => 'Tunggu 10 detik sebelum mengirim pesan berikutnya.'
            ], 429);
        }

        $message = PrivateMessage::create([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'message' => $request->message
        ]);

        broadcast(new PrivateMessageSent($message))->toOthers();

        return response()->json(['message' => $message]);
    }


    public function getUsersOnline(Request $request)
    {
        $limit = $request->input('limit', 20);
        $offset = $request->input('offset', 0);
        $search = $request->input('search');

        $query = DB::table('users')
            ->where('users.is_online', true)
            ->where('users.utype', 'MHS')
            ->where('users.username', '<>', Auth::user()->username);

        if ($search) {
            $query->where('users.name', 'LIKE', '%' . $search . '%');
        }

        $total = $query->count(); // total semua user online

        $data = $query
            ->leftJoin('private_messages', function ($join) {
                $join->on('users.id', '=', 'private_messages.sender_id')
                    ->orOn('users.id', '=', 'private_messages.receiver_id');
            })
            ->select('users.*', 'private_messages.created_at as message_time', 'private_messages.message')
            ->orderByDesc('private_messages.created_at')
            ->groupBy('users.id')
            ->offset($offset)
            ->limit($limit)
            ->get();

        return response()->json([
            'users' => $data,
            'total' => $total
        ]);
    }


    public function getMessages($userId, Request $request)
    {
        $limit = $request->input('limit', 20);
        $offset = $request->input('offset', 0);

        $messages = PrivateMessage::where(function ($query) use ($userId) {
            $query->where('sender_id', Auth::id())
                ->where('receiver_id', $userId);
        })
            ->orWhere(function ($query) use ($userId) {
                $query->where('sender_id', $userId)
                    ->where('receiver_id', Auth::id());
            })
            ->orderBy('created_at', 'desc') // Ambil dari terbaru ke lama dulu
            ->offset($offset)
            ->limit($limit)
            ->get()
            ->reverse() // Tampilkan dari lama ke baru
            ->values()
            ->map(function ($message) {
                $message->sender_name = $message->sender->name;
                $message->receiver_name = $message->receiver->name;
                return $message;
            });

        return response()->json($messages);
    }
}
