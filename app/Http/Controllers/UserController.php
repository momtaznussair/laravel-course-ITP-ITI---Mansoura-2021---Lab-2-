<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show($id)
    {
        $user = User::select()->findOrFail($id);
        return view('creators.show', ['user' => $user]);
    }
}
