<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');

    $users = User::where('type', '!=', 'admin') // Optionnel : Exclure les admins
        ->when($search, function ($query, $search) {
            $query->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
        })
        ->paginate(10); // Ajustez le nombre de résultats par page

    return view('utilisateurs.index', compact('users', 'search'));
}




    public function create()
    {
        return view('utilisateurs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'type' => 'required|in:admin,manager,commercial',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'type' => $request->type,
        ]);

        return redirect()->route('utilisateurs.index')->with('success', 'User added successfully.');
    }

    public function edit(User $user)
    {
        return view('utilisateurs.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'type' => 'required|in:admin,manager,commercial',
        ]);

        $user->update($request->only('name', 'email', 'type'));

        return redirect()->route('utilisateurs.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('utilisateurs.index')->with('success', 'User deleted successfully');
    }
}
