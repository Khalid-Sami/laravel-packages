<?php

namespace App\Http\Controllers\ControllerTest;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class Profile extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(User $user)
    {
        return $user->id;
    }
}
