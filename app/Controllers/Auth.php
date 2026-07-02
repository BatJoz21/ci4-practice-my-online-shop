<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    public function registerPage()
    {
        return view("Auth/register");
    }

    public function loginPage()
    {
        return view("Auth/login");
    }
}
