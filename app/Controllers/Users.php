<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\UserApiService;

class Users extends BaseController
{
    protected UserApiService $api;

    public function __construct()
    {
        $this->api = new UserApiService();
    }

    public function show()
    {
        $id = session("user")["id"];

        if(empty($id)) {
            return redirect()->to("login")
                             ->with("message", "Please login first");
        }

        $response = $this->api->getProfileData($id);
        if(!$response["success"]) {
            return redirect()->to("")
                             ->with("error", $response["message"]);
        }

        return view("Users/profile", ["profile" => $response["data"]]);
    }
}
