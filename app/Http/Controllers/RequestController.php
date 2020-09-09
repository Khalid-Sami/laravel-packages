<?php
/**
 * Created by PhpStorm.
 * User: Khalid S. Sabbah
 * Date: 12/3/2019
 * Time: 10:51 م
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class RequestController
{

    public function getPath(Request $request)
    {
        return $request->path();
    }

    public function isPath(Request $request)
    {
        if($request->is('path/*'))
            return 'yes';
        return 'no';
    }

    public function getURL(Request $request)
    {
        return $request->fullUrl();
    }

}
