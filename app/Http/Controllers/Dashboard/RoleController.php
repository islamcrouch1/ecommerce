<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:roles-read')->only('index', 'show');
        $this->middleware('permission:roles-create')->only('create', 'store');
        $this->middleware('permission:roles-update')->only('edit', 'update');
        $this->middleware('permission:roles-delete|roles-trash')->only('destroy', 'trashed');
        $this->middleware('permission:roles-restore')->only('restore');
    }


    public function index()
    {
        $roles = Role::WhereRoleNot(['Administrator', 'user', 'vendor', 'affiliate'])
            ->whenSearch(request()->search)
            ->with('permissions')
            ->withCount('users')
            ->latest()
            ->paginate(100);
        return view('dashboard.roles.index')->with('roles', $roles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $data = $this->getModels();
        return view('dashboard.roles.create', compact('data'));
    }


    private function getModels()
    {


        $models['en'] = [
            'categories',
            'orders',
            'vendor_orders',
            'products',
            'shipping_rates',
            'withdrawals',
            'messages',
            'orders_report',
            'slides',
            'logs',
            'bonus',
            'warehouses',
            'add_stock',
            'stock_lists',
            'stock_inventory',
            'stock_transfers',
            'stock_shortages',
            'running_orders',
            'brands',
            'attributes',
            'variations',
            'shipping_methods',
            'medias',
            'accounts',
            'taxes',
            'petty_cash',
            'entries',
            'quick_entries',
            'purchases',
            'income_statement',
            'sales',
            'credit_management',
            'stages',
            'previews',
            'previews_clients',
            'previews_score',
            'assets',
            'cash_accounts',
            'accounting_operations',
            'balance_statement',
            'crm',
            'vendor_products',
            'trial_balance',
            'payments',
            'coupons',
            'carts',
            'website_traffic',
            'offers',
            'testimonials',
            'reviews',
            'installment_companies',
            'installment_requests',
            'employees',
            'attendances',
            'rewards',
            'payroll',
            'employee_permissions',
            'contacts',
            'units_categories',
            'units',
            'boms',
            'manufacturing_orders',
            'quotations',
            'rfq',
            'currencies',
            'exchange_rates',
            'invoices',
        ];


        $data['models'] = [
            'Users & Roles' => [
                'users', 'roles',
            ],
            'Users pages' => [
                'user_permissions', 'notifications',
            ],
            'Settings' => [
                'settings', 'website_setting', 'logs', 'messages', 'bonus'
            ],
            'Countries && Shipping' => [
                'countries', 'states', 'cities', 'shipping_companies', 'branches',
            ],
            'HR' => [
                'employees', 'attendances', 'rewards', 'payroll', 'employee_permissions'
            ],
            'website management' => [
                'website_categories',  'slides', 'posts'
            ],
            'Medias' => [
                'medias'
            ],
            'Marketing' => [
                'carts', 'coupons', 'website_traffic', 'offers', 'testimonials'
            ],
            'CRM' => [
                'crm', 'contacts', 'notes', 'queries',
            ],
            'Credit Management' => [
                'credit_management', 'stages', 'previews_clients', 'previews'
            ],
            'Products && categories' => [
                'categories', 'brands', 'attributes', 'variations', 'products', 'vendor_products', 'units_categories', 'units',
            ],
            'Warehouses Management' => [
                'warehouses', 'add_stock', 'stock_lists', 'stock_inventory', 'stock_transfers', 'stock_shortages', 'running_orders',
            ],
            'Website orders' => [
                'orders', 'vendor_orders', 'installment_requests', 'withdrawals', 'orders_report', 'orders_notes',

            ],
            'Purchases' => [
                'purchases', 'rfq'
            ],
            'Sales' => [
                'sales', 'quotations', 'invoices'
            ],
            'Accounts' => [
                'accounts', 'assets', 'entries', 'trial_balance', 'income_statement', 'balance_statement', 'taxes', 'cash_accounts', 'petty_cash', 'currencies', 'exchange_rates',
            ],
            'manufacturing' => [
                'boms', 'manufacturing_orders'
            ],
        ];

        $data['permissions'] = ['create', 'update', 'read', 'delete', 'trash', 'restore'];

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => "required|string|unique:roles,name",
            'description' => "string",
            'permissions' => "required|array|min:1",
        ]);

        foreach ($request->permissions as $permission) {
            if (Permission::where('name', $permission)->first() == null) {
                Permission::create([
                    'name' => $permission,
                    'display_name' => $permission,
                    'description' => $permission
                ]);
            }
        }

        $role = Role::create($request->all());
        $role->attachPermissions($request->permissions);

        alertSuccess('Role created successfully', 'تم إنشاء الدور بنجاح');
        return redirect()->route('roles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($role)
    {
        $role = Role::find($role);
        $data = $this->getModels();
        return view('dashboard.roles.edit', compact('role', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => "required|string|unique:roles,name," . $role->id,
            'description' => "string",
            'permissions' => "required|array|min:1",
        ]);

        foreach ($request->permissions as $permission) {
            if (Permission::where('name', $permission)->first() == null) {
                Permission::create([
                    'name' => $permission,
                    'display_name' => $permission,
                    'description' => $permission
                ]);
            }
        }

        $role->update($request->all());
        $role->syncPermissions($request->permissions);

        alertSuccess('Role updated successfully', 'تم تعديل الدور بنجاح');
        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($role)
    {
        $role = Role::withTrashed()->where('id', $role)->first();
        if ($role->trashed() && auth()->user()->hasPermission('roles-delete')) {
            $role->forceDelete();
            alertSuccess('role deleted successfully', 'تم حذف الدور بنجاح');
            return redirect()->route('roles.trashed');
        } elseif (!$role->trashed() && auth()->user()->hasPermission('roles-trash') && checkRoleForTrash($role)) {
            $role->delete();
            alertSuccess('role trashed successfully', 'تم حذف الدور مؤقتا');
            return redirect()->route('roles.index');
        } else {
            alertError('Sorry, you do not have permission to perform this action, or the role cannot be deleted at the moment', 'نأسف ليس لديك صلاحية للقيام بهذا الإجراء ، أو الدور لا يمكن حذفها حاليا');
            return redirect()->back()->withInput();
        }
    }



    public function trashed()
    {
        $roles = Role::onlyTrashed()->paginate(100);
        return view('dashboard.roles.index', ['roles' => $roles]);
    }

    public function restore($role)
    {
        $role = Role::withTrashed()->where('id', $role)->first()->restore();
        alertSuccess('Role restored successfully', 'تم إستعادة الدور بنجاح');
        return redirect()->route('roles.index');
    }
}
