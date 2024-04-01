<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Business;
use App\Models\Position;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $condition = auth()->user()->role_id == 1 && auth()->user()->position_id == 1;
        $roles = tenant() ? Role::whereNot('id', 1)->get() : Role::where('id', 1)->get();
        $positions = Position::whereNot('id', 1)->get();
        $business_relation = $condition ? null : 'business';
        $businesses = $condition ? null : Business::when(auth()->user()->business_id, fn($q, $v) => $q->where('id', $v))->get();

        $users = User::where('approve', true)->where('position_id', '!=', 1)
        ->when(auth()->user()->business_id, fn($q, $v) => $q->where('business_id', $v))
        ->when($request->search_item, fn($q, $v) => $q->where('name', 'LIKE', '%'. $v .'%')->orWhere('phone', 'LIKE', '%' . $v .'%')->orWhere('email', 'LIKE', '%' . $v . '%')->where('approve', true)->where('position_id', '!=', 1))
        ->when($request->filter_business, fn($q, $v) => $q->where('business_id', $v))
        ->when($request->filter_role, fn($q, $v) => $q->where('role_id', $v))
        ->when($request->filter_position, fn($q, $v) => $q->where('position_id', $v))
        ->with(['role', 'position'])->paginate(10);

        $business_relation ? $users->load('business') : null;

        return Inertia::render('User/User', [
            'users' => $users,
            'roles' => $roles,
            'businesses' => $businesses,
            'positions' => $positions,
            'exists' => User::query()->count() >= 2,
            'search_item' => $request->search_item,
            'filter_business' => $request->filter_business ?? '',
            'filter_role' => $request->filter_role ?? '',
            'filter_position' => $request->filter_position ?? '',
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
    public function store(UserRequest $request)
    {
        $path = $request->avatar ? Storage::disk('upload')->put('avatars', $request->avatar) : null;
        $validatedData = $request->validated();
        $validatedData['approve'] = true;
        $validatedData['avatar'] = $path;
        User::create($validatedData);
        return to_route('user.index')->with('message', 'Created Successfully!');
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
    public function update(UserRequest $request, User $user)
    {
        if ($request->avatar) {
            if ($request->avatar != $user->avatar) {
                $path = Storage::disk('upload')->put('avatars', $request->avatar);
                $old = $user->avatar;
                if ($old) {
                    Storage::disk('upload')->delete($old);
                }
            } else {
                $path = $request->avatar;
            }
        } else {
            $path = $user->avatar;
        }
        $password = $request->password ? Hash::make($request->password) : $user->password;
        $validatedData = $request->validated();
        $validatedData['avatar'] = $path;
        $validatedData['password'] = $password;
        $user->update($validatedData);
        return to_route('user.index')->with('message', 'Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($user, Request $request)
    {
        if ($user == 'all') {
            User::whereNot('role_id', 1)->whereNot('position_id', 1)->each(function ($user) {
                if ($user->avatar) {
                    Storage::disk('upload')->delete($user->avatar);
                }
                $user->delete();
            });
        } else {
            $search_id = $user == 'param' ? $request->selected_ids : [$user];
            $users = User::whereIn('id', $search_id)->get();
            foreach ($users as $user) {
                if ($user->avatar) {
                    Storage::disk('upload')->delete($user->avatar);
                }
                $user->delete();
            }
        }
        return to_route('user.index')->with('message', 'Deleted Successfully!');
    }
}
