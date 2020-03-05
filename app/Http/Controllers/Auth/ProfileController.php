<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\APIController;

class ProfileController extends APIController
{
    /**
     * Display details on the logged in user
     *
     * @return \Illuminate\Http\Response
     */
    public function me()
    {
        return response()->json([
            'status' => 200,
            'user'=> auth()->user()
        ],200);
    }
}
