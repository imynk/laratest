<?php

namespace App\Http\Controllers;
use App\Models\Userapi;
use Illuminate\Http\Request;

class UserapiController extends Controller
{
    public function index()
    {

        $alluser = Userapi::all();
        return response()->json($alluser);
    }
    public function search(Request $request)
    {
        $query = $request->input('search'); // Match the parameter name

        if (empty($query)) {
            return response()->json([]); // Return empty if no search term is provided
        }

        $users = Userapi::where('email', 'like', "%{$query}%")
            ->orWhere('first_name', 'like', "%{$query}%")
            ->get();

        return response()->json($users);
    }
    public function adduser(Request $request)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'avatar' => 'nullable|url',
        ]);
    
        // Retrieve validated data
        $user = new Userapi();
        $user->first_name = $validatedData['first_name'];
        $user->last_name = $validatedData['last_name'];
        $user->email = $validatedData['email'];
        $user->avatar = $validatedData['avatar'] ?? null;
    
        // Save the new user to the database
        $user->save();
    
        return response()->json($user);
    }
}    
