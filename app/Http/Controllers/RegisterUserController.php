<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;

class RegisterUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::where('approve', false)
                ->when($request->search_item, function($q, $v){
                    return $q->where('name', 'LIKE', '%'. $v .'%');
                })
                ->paginate(10);
        return Inertia::render('RegisterUser/RegisterUser', [
            'users' => $users,
            'search_item' => $request->search_item,
            'exists' => User::where('approve', false)->exists(),
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
    public function store(Request $request)
    {
        //
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
    public function update($id)
    {
        $user = User::find($id);
        $user->update([ 'approve' => true ]);
        return to_route('reg_user.index')->with('message', 'Approved Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $search_id)
    {
        User::where('id', $search_id)->delete();
        return to_route('reg_user.index')->with('message', 'Rejected Successfully!');
    }
}
