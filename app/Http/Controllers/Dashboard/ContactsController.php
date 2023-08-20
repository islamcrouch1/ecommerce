<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:contacts-read')->only('index', 'show');
        $this->middleware('permission:contacts-create')->only('create', 'store');
        $this->middleware('permission:contacts-update')->only('edit', 'update');
        $this->middleware('permission:contacts-delete|contacts-trash')->only('destroy', 'trashed');
        $this->middleware('permission:contacts-restore')->only('restore');
    }


    public function index()
    {
        $contacts = Contact::whenSearch(request()->search)
            ->latest()
            ->paginate(100);
        return view('dashboard.contacts.index', compact('contacts'));
    }




    public function destroy($contact)
    {
        $contact = Contact::withTrashed()->where('id', $contact)->first();
        if ($contact->trashed() && auth()->user()->hasPermission('contacts-delete')) {

            $contact->forceDelete();
            alertSuccess('contact deleted successfully', 'تم حذف الرسالة بنجاح');
            return redirect()->route('contacts.trashed');
        } elseif (!$contact->trashed() && auth()->user()->hasPermission('contacts-trash')) {
            $contact->delete();
            alertSuccess('contact trashed successfully', 'تم حذف الرسالة مؤقتا');
            return redirect()->route('contacts.index');
        } else {
            alertError('Sorry, you do not have permission to perform this action, or the contact cannot be deleted at the moment', 'نأسف ليس لديك صلاحية للقيام بهذا الإجراء ، أو الرسالة لا يمكن حذفها حاليا');
            return redirect()->back()->withInput();
        }
    }


    public function trashed()
    {
        $contacts = Contact::onlyTrashed()
            ->whenSearch(request()->search)
            ->paginate(100);
        return view('dashboard.contacts.index', ['contacts' => $contacts]);
    }

    public function restore($contact)
    {
        $contact = Contact::withTrashed()->where('id', $contact)->first()->restore();
        alertSuccess('contact restored successfully', 'تم استعادة الرسالة بنجاح');
        return redirect()->route('contacts.index');
    }
}
