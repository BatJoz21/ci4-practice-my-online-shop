<?php

namespace App\Services;

class UserApiService extends BaseApiService
{
    public function getAllUser()
    {
        return $this->handleRequest(function() {
            return $this->client->get("admin/users", [
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
