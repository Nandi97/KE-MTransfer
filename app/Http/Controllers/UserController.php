<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('query');

        $results = User::where('email', 'ILIKE', "%$query%")
            ->orWhere('phone', 'ILIKE', "%$query%")
            ->select('id', 'name', 'email', 'phone')
            ->get();

        return response()->json($results);
    }
}
