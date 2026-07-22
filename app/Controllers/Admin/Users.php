<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Services\UserApiService;

class Users extends BaseController
{
    protected UserApiService $api;

    public function __construct()
    {
        $this->api = new UserApiService();
    }

    public function index()
    {
        $page = $this->request->getGet("page") ?? "1";
        $search = $this->request->getGet("search") ?? "";
        $role = $this->request->getGet("role") ?? "";

        $response = $this->api->getAllUser($search, $role, $page);
        $users = [];
        if($response["success"]) {
            $users = $response["data"];
        }

        $totalPages = ceil(count($users) / 20);

        return view("Users/admin/index", [
            "users"         => $users,
            "search"        => $search,
            "selectedRole"  => $role,
            "totalPages"    => $totalPages
        ]);
    }

    public function show(int $id)
    {
        $response = $this->api->getUser($id);
        if(!$response["success"]) {
            return redirect()->to("admin/users")
                             ->with("error", "User not found");
        }

        return view("Users/admin/view", ["user" => $response["data"]]);
    }

    public function updateRole(int $id)
    {
        $response = $this->api->updateUserRole($id, $this->request->getPost("role"));
        if(!$response["success"]) {
            return redirect()->to("admin/users")
                             ->with("error", "Failed to update user's role: " . $response["message"]);
        }

        return redirect()->to("admin/users/" . $id)
                         ->with("message", "User's role updated");
    }
}
