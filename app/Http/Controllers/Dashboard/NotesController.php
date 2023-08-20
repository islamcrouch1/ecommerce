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
            'role' => "required|string",
        ]);

        $note = Note::create([
            'note' => $request['note'],
            'user_id' => $user->id,
            'admin_id' => Auth::user()->id,
        ]);



        $description_ar = "تم اضافة ملاحظة لعميل - " . $user->name . ' - ' . $request['note'];
        $description_en  = "note added for client - " .  $user->name . ' - ' . $request['note'];
        addLog('admin', 'users', $description_ar, $description_en);


        $users = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'user');
        })->get();

        if ($request['role'] !== '0') {


            foreach ($users as $admin) {

                $title_ar = 'تم اضافة ملاحظة لعميل - ' . $user->name;
                $body_ar = $request['note'];
                $title_en = 'not has been added to user - ' . $user->name;
                $body_en  = $request['note'];
                $url = route('users.show', ['user' => $user->id]);

                if ($admin->id != Auth::user()->id && $admin->hasRole($request['role'])) {
                    addNoty($admin, Auth::user(), $url, $title_en, $title_ar, $body_en, $body_ar);
                }
            }
        }


        alertSuccess('user note created successfully', 'تم إضافة ملاحظة على المستخدم بنجاح');
        return redirect()->route('users.show', ['user' => $user->id]);
    }


    public function edit(Note $note)
    {
        return view('dashboard.users.note ')->with('note', $note);
    }

    public function update(Request $request, Note $note)
    {

        $request->validate([
            'note' => "required|string",

        ]);

        $note->update([
            'note' => $request['note'],
        ]);


        $description_ar = "تم تعديل ملاحظة لعميل - " . $note->user->name . ' - ' . $request['note'];
        $description_en  = "note updated for user - " .  $note->user->name . ' - ' . $request['note'];
        addLog('admin', 'users', $description_ar, $description_en);


        alertSuccess('user note updated successfully', 'تم تعديل الملاحظة من العميل بنجاح');
        return redirect()->route('users.show', ['user' => $note->user->id]);
    }


    public function destroy(Note $note)
    {
        $user_id = $note->user_id;
        $user = User::findOrFail($user_id);

        $description_ar = "تم حذف الملاحظة لعميل - " . $user->name . ' - ' . $note->note;
        $description_en  = "note added from user - " .  $user->name . ' - ' . $note->note;
        addLog('admin', 'users', $description_ar, $description_en);


        $note->delete();
        alertSuccess('note deleted successfully', 'تم حذف الملاحظة بنجاح');
        return redirect()->route('users.show', ['user' => $user_id]);
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
        return redirect()->back()->withInput();
    }
}
