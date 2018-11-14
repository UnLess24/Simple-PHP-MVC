<?php

namespace App\Controllers;

use App\Kernel\MyPDO;
use App\Kernel\Request;

class UserController extends Controller
{
    public function getLoginAdmin(Request $request = null)
    {
        view('admin/login.php');
    }

    public function postLoginAdmin(Request $request)
    {
        $name = $request->name;
        $password = $request->password;

        if ($name === 'Admin' && $password === '123') {
            setcookie('user', 'admin', time() + 60*60, '/');
        } else {
            setcookie('user', '', null, '/');
        }
        header('Location: /');
    }

    public function getLogoutAdmin()
    {
        setcookie('user', '', null, '/');
        header('Location: /');
    }
}
