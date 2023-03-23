<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Query;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QueriesController extends Controller
{
    public function addUserQuery(Request $request, User $user)
    {
        $request->validate([
            'query' => "required|string",
            'query_type' => "required|string",
            'role' => "required|string",

        ]);

        $query = Query::create([
            'query' => $request['query'],
            'query_type' => $request['query_type'],
            'user_id' => $user->id,
            'admin_id' => Auth::user()->id,
        ]);


        $description_ar = "تم اضافة استفسار لعميل - " . $user->name . ' - ' . $request['query'];
        $description_en  = "query added from user - " .  $user->name . ' - ' . $request['query'];
        addLog('admin', 'users', $description_ar, $description_en);


        $users = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'user');
        })->get();


        if ($request['role'] !== '0') {

            foreach ($users as $admin) {

                $title_ar = 'تم اضافة استفسار من عميل';
                $body_ar = $request['query'];
                $title_en = 'Message from technical support';
                $body_en  = $request['query'];
                $url = route('users.show', ['user' => $user->id]);

                if ($admin->id != Auth::user()->id && $admin->hasRole($request['role'])) {
                    addNoty($admin, Auth::user(), $url, $title_en, $title_ar, $body_en, $body_ar);
                }
            }
        }




        alertSuccess('user query created successfully', 'تم إضافة استفسار من العميل بنجاح');
        return redirect()->route('users.show', ['user' => $user->id]);
    }



    public function edit(Query $query)
    {
        return view('Dashboard.users.query ')->with('query', $query);
    }

    public function update(Request $request, query $query)
    {

        $request->validate([
            'query' => "required|string",
            'query_type' => "required|string",

        ]);

        $query->update([
            'query' => $request['query'],
            'query_type' => $request['query_type'],
        ]);


        $description_ar = "تم تعديل استفسار لعميل - " . $query->user->name . ' - ' . $request['query'];
        $description_en  = "query added from user - " .  $query->user->name . ' - ' . $request['query'];
        addLog('admin', 'users', $description_ar, $description_en);


        alertSuccess('user query updated successfully', 'تم تعديل استفسار من العميل بنجاح');
        return redirect()->route('users.show', ['user' => $query->user->id]);
    }


    public function destroy(Query $query)
    {
        $user_id = $query->user_id;
        $user = User::findOrFail($user_id);

        $description_ar = "تم حذف استفسار لعميل - " . $user->name . ' - ' . $query->query;
        $description_en  = "query added from user - " .  $user->name . ' - ' . $query->query;
        addLog('admin', 'users', $description_ar, $description_en);


        $query->delete();
        alertSuccess('Query deleted successfully', 'تم حذف الاستفسار بنجاح');
        return redirect()->route('users.show', ['user' => $user_id]);
    }
}
