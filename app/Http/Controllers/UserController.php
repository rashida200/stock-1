<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::when($search, function ($query, $search) {
            $query->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
        })
            ->paginate(10);

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

        return redirect()->route('utilisateurs.index')->with('success', 'Utilisateur créé avec succès.');
    }





    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('utilisateurs.index')->with('success', 'User deleted successfully');
    }






    public function edit($id)
{
    $user = User::findOrFail($id);
    return view('utilisateurs.edit', compact('user'));
}

public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => [
            'required',
            'email',
            Rule::unique('users')->ignore($user->id),
        ],
        'password' => 'nullable|string|min:8',
        'type' => 'required|in:admin,manager,commercial',
    ]);

    $data = [
        'name' => $request->name,
        'email' => $request->email,
        'type' => $request->type,
    ];

    if ($request->filled('password')) {
        $data['password'] = bcrypt($request->password);
    }

    $user->update($data);

    return redirect()->route('utilisateurs.index')->with('success', 'Utilisateur mis à jour avec succès.');
}
}
