<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Note;
use App\Models\Order;
use App\Models\OrderNote;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotesController extends Controller
{
    public function addUserNote(Request $request, User $user)
    {
        $request->validate([
            'note' => "required|string",
        ]);

        $note = Note::create([
            'note' => $request['note'],
            'user_id' => $user->id,
            'admin_id' => Auth::user()->id,
        ]);

        alertSuccess('user note created successfully', 'تم إضافة ملاحظة على المستخدم بنجاح');
        return redirect()->route('users.show', ['user' => $user->id]);
    }


    public function addorderNote(Order $order, Request $request)
    {
        $request->validate([
            'note' => "required|string",
        ]);

        $note = OrderNote::create([
            'note' => $request['note'],
            'user_id' => Auth::user()->id,
            'order_id' => $order->id,
        ]);

        alertSuccess('order note created successfully', 'تم إضافة ملاحظة على الطلب بنجاح');
        return redirect()->back();
    }
}
