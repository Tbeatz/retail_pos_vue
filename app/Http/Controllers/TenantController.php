<?php

namespace App\Http\Controllers;

use App\Http\Requests\TenantRequest;
use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Inertia\Inertia;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tenants = Tenant::when($request->search_item, function($q, $v){
                        return $q->where('email', 'LIKE', '%'. $v .'%')
                                ->orWhere('id', 'LIKE', '%'. $v .'%')
                                ->orWhere('name', 'LIKE', '%'. $v .'%')
                                ->orWhere('phone', 'LIKE', '%'. $v .'%')
                                ->orwhereHas('domains', function($q) use($v){
                                    return $q->where('domain', 'LIKE', '%'. $v .'%');
                                });
                    })->with('domains')->paginate(10);
                    
        return Inertia::render('Tenant/Tenant', [
            'tenants' => $tenants,
            'search_item' => $request->search_item,
            'exists' => Tenant::exists(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //No need becz i did with modal
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TenantRequest $request)
    {
        $validatedData = $request->validated();
        $tenant = Tenant::create($validatedData);

        $tenant->domains()->create([
            'domain' => $validatedData['domain'],
        ]);

        $tenant->run(function($t){
            User::create([
                'name' => $t->name,
                'phone' => $t->phone,
                'address' => $t->address,
                'email' => $t->email,
                'password' => Hash::make($t->password),
                'approve' => true,
                'role_id' => 1, //Admin
                'position_id' => 2, //Super admin
            ]);
        });

        return to_route('tenant.index')->with('message', 'Created Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TenantRequest $request, Tenant $tenant)
    {
        $validatedData = $request->validated();

        $tenant->domains()->update([
            'domain' => $validatedData['domain'],
        ]);
        
        $tenant->update($request->validated());
        
        $tenant->run(function($t){
            $user = User::where('role_id', 1)->update([
                'name' => $t->name,
                'phone' => $t->phone,
                'address' => $t->address,
                'email' => $t->email,
                'password' => Hash::make($t->password),
            ]);
        });

        return to_route('tenant.index')->with('message', 'Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($tenant, Request $request)
    {
        if ($tenant == 'all') {
            $_tenants = Tenant::get();
            foreach ($_tenants as $_tenant) {
                Schema::dropIfExists($_tenant->tenancy_db_name);
                $_tenant->delete();
            }
        } else {
            $search_id = $tenant == 'param' ? $request->selected_ids : [$tenant];
            $_tenants = Tenant::whereIn('id', $search_id)->get();
            foreach ($_tenants as $_tenant) {
                Schema::dropIfExists($_tenant->tenancy_db_name);
                $_tenant->delete();
            }
        }
        return to_route('tenant.index')->with('message', 'Deleted Successfully!');
    }
}
