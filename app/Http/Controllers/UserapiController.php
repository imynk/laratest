<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserapiController extends Controller
{
    
    public function search(Request $request)
{
    $query = $request->input('query');
    $users = User::where('email', 'like', "%{$query}%")
        ->orWhere('first_name', 'like', "%{$query}%")
        ->get();

    return response()->json($users);
}

}
