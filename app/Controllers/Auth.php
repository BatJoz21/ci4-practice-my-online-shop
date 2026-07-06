<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\AuthApiService;

class Auth extends BaseController
{
    private AuthApiService $api;

    public function __construct()
    {
        $this->api = new AuthApiService();
    }

    public function registerPage()
    {
        return view("Auth/register");
    }

    public function register()
    {
        $newUser = [
            "name"      => $this->request->getPost("name"),
            "email"     => $this->request->getPost("email"),
            "password"  => $this->request->getPost("password")
        ];

        $response = $this->api->signup($newUser);

        if(!$response["isRegistered"]) {
            return redirect()->back()
                             ->with("error", $response["message"])
                             ->withInput();
        }

        return redirect()->to("login")
                         ->with("message", $response["message"]);
    }

    public function loginPage()
    {
        return view("Auth/login");
    }

    public function login()
    {
        $response = $this->api->login(
            $this->request->getPost("email"),
            $this->request->getPost("password")
        );

        session()->set([
            "logged_in"         => true,
            "jwt_token"         => $response["jwt_token"],
            "refresh_token"     => $response["refresh_token"],
            "user"              => $response["user"]
        ]);

        return redirect()->to("/");
    }

    public function logout()
    {
        $response = $this->api->logout(session("refresh_token"));
        if(!$response["isLoggedOut"]) {
            return redirect()->to("")
                             ->with("error", "Failed to log out");
        }

        session()->destroy();

        return redirect()->to("login")
                         ->with("message", "User has logged out");
    }
}
