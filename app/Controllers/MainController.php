<?php

namespace App\Controllers;

use App\Kernel\Request;

class MainController extends Controller
{
    public function getMain(Request $request = null)
    {
        $data = [];

        if ($request)
            $data = $request->getParams();

        return view('home.php', $data);
    }
}
