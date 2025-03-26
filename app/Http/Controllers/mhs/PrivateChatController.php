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
        $currentUserId = Auth::id();

        // ✅ User yang pernah chat dengan kita
        $chatUsers = DB::table('users')
            ->leftJoin('private_messages', function ($join) use ($currentUserId) {
                $join->on('users.id', '=', 'private_messages.sender_id')
                    ->where('private_messages.receiver_id', '=', $currentUserId)
                    ->orOn('users.id', '=', 'private_messages.receiver_id')
                    ->where('private_messages.sender_id', '=', $currentUserId);
            })
            ->where('users.is_online', true)
            ->where('users.utype', 'MHS')
            ->where('users.id', '<>', $currentUserId)
            ->when($search, function ($query) use ($search) {
                $query->where('users.name', 'LIKE', '%' . $search . '%');
            })
            ->select(
                'users.id',
                'users.name',
                'users.username',
                'users.kode',
                DB::raw('MAX(private_messages.created_at) as last_chat_time'),
                DB::raw('SUM(CASE 
                WHEN private_messages.receiver_id = ' . $currentUserId . ' AND private_messages.is_read = 0 
                THEN 1 ELSE 0 END) as unread_count')
            )
            ->groupBy('users.id', 'users.name', 'users.username', 'users.kode')
            ->havingRaw('MAX(private_messages.created_at) IS NOT NULL') // hanya user yang pernah chat
            ->orderByDesc('last_chat_time')
            ->get();


        // ✅ User online tapi belum pernah chat dengan kita
        $nonChatUsers = DB::table('users')
            ->where('users.is_online', true)
            ->where('users.utype', 'MHS')
            ->where('users.id', '<>', $currentUserId)
            ->whereNotIn('users.id', $chatUsers->pluck('id'))
            ->when($search, function ($query) use ($search) {
                $query->where('users.name', 'LIKE', '%' . $search . '%');
            })
            ->select(
                'users.id',
                'users.name',
                'users.username',
                'users.kode',
                DB::raw('users.updated_at as last_chat_time')
            )
            ->orderByDesc('users.updated_at')
            ->get();

        // ✅ Gabungkan & batasi hasil
        $merged = $chatUsers->merge($nonChatUsers)
            ->slice($offset)
            ->take($limit)
            ->values();

        // Total user online (selain diri sendiri)
        $total = DB::table('users')
            ->where('is_online', true)
            ->where('utype', 'MHS')
            ->where('id', '<>', $currentUserId)
            ->count();

        return response()->json([
            'users' => $merged,
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
        PrivateMessage::where('sender_id', $userId)
            ->where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json($messages);
    }
}
