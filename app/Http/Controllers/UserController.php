<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|string',
            'email' => ['required', Rule::unique('users', 'email')->ignore($user)],
        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        if($request->hasFile('image')){
            $user->image = $request->image->store('users');
        }
        $user->save();
        return back()->with('success', 'Profile has been updated.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', "The user '$user->name' has been deleted.");
    }
}