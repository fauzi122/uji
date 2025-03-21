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
            'message' => 'required'
        ]);

        $message = PrivateMessage::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message
        ]);

        broadcast(new PrivateMessageSent($message))->toOthers();

        return response()->json(['message' => $message]);
    }

    public function getUsersOnline()
    {
        // Mengambil user yang online dan pesan terakhir mereka
        $users = DB::table('users')
            ->leftJoin('private_messages', function ($join) {
                // Menggabungkan tabel users dengan private_messages berdasarkan sender_id dan receiver_id
                $join->on('users.id', '=', 'private_messages.sender_id')
                    ->orOn('users.id', '=', 'private_messages.receiver_id');
            })
            ->where('users.is_online', true)
            ->select('users.*', 'private_messages.created_at as message_time', 'private_messages.message')
            ->orderByDesc('private_messages.created_at')  // Urutkan berdasarkan pesan terbaru
            ->groupBy('users.id')  // Kelompokkan berdasarkan user.id untuk mengambil data user yang unik
            ->get();

        // Mengembalikan data dalam format JSON
        return response()->json($users);
    }
}
