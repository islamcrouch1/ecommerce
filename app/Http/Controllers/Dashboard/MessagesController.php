<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:messages-read')->only('index', 'show');
        $this->middleware('permission:messages-create')->only('create', 'store');
        $this->middleware('permission:messages-update')->only('edit', 'update');
        $this->middleware('permission:messages-delete|messages-trash')->only('destroy', 'trashed');
        $this->middleware('permission:messages-restore')->only('restore');
    }

    public function index()
    {
        $messages = Message::whenSearch(request()->search)
            ->latest()
            ->paginate(100);
        return view('Dashboard.messages.admin')->with('messages', $messages);
    }


    public function store(Request $request, User $user)
    {
        $request->validate([
            'message' => "required|string",
        ]);


        $admin = Auth::user();

        $message = Message::create([
            'message' => $request['message'],
            'user_id' => $user->id,
            'sender_id' => $admin->id,
        ]);

        $title_ar = 'رسالة من الدعم الفني';
        $body_ar = $message->message;
        $title_en = 'Message from technical support';
        $body_en  = $message->message;
        $url = route('messages.index');

        addNoty($user, $user, $url, $title_en, $title_ar, $body_en, $body_ar);

        alertSuccess('message sent successfully', 'تم الإرسال بنجاح');
        return redirect()->route('users.show', ['user' => $user->id]);
    }

    public function destroy(Message $message)
    {
        $user_id = $message->user_id;
        $message->delete();
        alertSuccess('message deleted successfully', 'تم حذف الرسالة بنجاح');
        return redirect()->route('users.show', ['user' => $user_id]);
    }
}
