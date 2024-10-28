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
    
}
