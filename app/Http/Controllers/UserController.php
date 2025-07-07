<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        //
    }

    public function show(Request $request, User $user)
    {
        //
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        //
    }

    public function destroy(Request $request, User $user)
    {
        //
    }
}
