<?php

namespace App\Http\Controllers\ControllerTest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Follows extends Controller
{
    public function __construct()
    {
        $this->middleware('check.user')->except('followers');
    }

    public function followers()
    {
        return 'Followers';
    }

    public function following()
    {
        return 'Following';
    }
}
