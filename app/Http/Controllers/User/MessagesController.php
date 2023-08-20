<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{

    public function index()
    {
        $messages = Message::where('user_id', Auth::id())
            ->orWhere('sender_id',  Auth::id())
            ->whenSearch(request()->search)
            ->latest()
            ->paginate(50);

        return view('dashboard.messages.index', compact('messages'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'message' => "required|string",
        ]);

        $user = Auth::user();
        $message = Message::create([
            'message' => $request['message'],
            'user_id' => 0,
            'sender_id' => $user->id,
        ]);

        $admins = unserialize(setting('messages_notifications'));

        $users = User::whereHas('roles', function ($query) use ($admins) {
            $query->whereIn('name', $admins ? $admins : []);
        })->get();




        foreach ($users as $admin) {

            $title_ar = 'يوجد رسالة جديدة للدعم الفني';
            $body_ar = $message->message;
            $title_en = 'There is a new message for technical support';
            $body_en  = $message->message;
            $url = route('messages.admin.index');

            addNoty($admin, $user, $url, $title_en, $title_ar, $body_en, $body_ar);
        }

        alertSuccess('your message sent successfully', 'تم إرسال رسالتك بنجاح');
        return redirect()->route('messages.index');
    }
}
