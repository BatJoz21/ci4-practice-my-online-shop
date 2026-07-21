<?php

namespace App\Services;

class UserApiService extends BaseApiService
{
    public function getAllUser(string $search, string $role, string $page)
    {
        $uri = "admin/users?page=" . $page;

        if(!empty($search)) {
            $uri = $uri . "&search=" . $search;
        }

        if(!empty($role)) {
            $uri = $uri . "&role=" . $role;
        }

        return $this->handleRequest(function() use($uri) {
            return $this->client->get($uri, [
                "headers"   => $this->getHeaders()
            ]);
        });
    }

    public function getUser(int $id)
    {
        return $this->handleRequest(function() use($id) {
            return $this->client->get("admin/users/" . $id, [
                "headers"   => $this->getHeaders()
            ]);
        });
    }

    public function getProfileData(int $id)
    {
        return $this->handleRequest(function() use($id) {
            return $this->client->get("profile/" . $id, [
                "headers"       => $this->getHeaders()
            ]);
        });
    }

    public function updateUserRole(int $id, string $role)
    {
        return $this->handleRequest(function() use($id, $role) {
            return $this->client->put("admin/users/" . $id . "/role", [
                "headers"   => $this->getHeaders(),
                "json"      => ["role" => $role]
            ]);
        });
    }
}
